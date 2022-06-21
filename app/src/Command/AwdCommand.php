<?php

declare(strict_types=1);

namespace App\Command;

use App\Database\Advertisement;
use App\Exception\EnvironmentError;
use App\Job\TelegramMessageJob;
use App\Repository\AdvertisementRepository;
use Cycle\ORM\TransactionInterface;
use DateTimeImmutable;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SimpleXMLElement;
use Spiral\Boot\EnvironmentInterface;
use Spiral\Console\Command;
use Spiral\Jobs\QueueInterface;
use Throwable;
use Exception;

class AwdCommand extends Command
{
    protected const NAME = 'awd:ads';

    protected const DESCRIPTION = 'Get all the ads';

    /** @var string */
    private string $url;

    /** @var Client */
    private Client $httpClient;

    /** @var AdvertisementRepository */
    private AdvertisementRepository $advertisementRepository;

    /** @var TransactionInterface $tr */
    private TransactionInterface $tr;

    /** @var QueueInterface */
    private QueueInterface $queue;

    /** @var string */
    private $chatId;

    /**
     * Constructor
     *
     * @throws EnvironmentError
     */
    public function __construct(
        AdvertisementRepository $advertisementRepository,
        TransactionInterface $tr,
        QueueInterface $queue,
        EnvironmentInterface $environment
    ) {
        $this->advertisementRepository = $advertisementRepository;
        $this->tr = $tr;
        $this->queue = $queue;
        $this->url = "https://forum.awd.ru/smartfeed.php";
        $this->chatId = $environment->get('TG_NOTY_CHAT_ID_AWD');
        $this->httpClient = new Client([
            'allow_redirects' => false,
            'exceptions' => false
        ]);

        if (boolval($this->chatId) === false) {
            throw new EnvironmentError('Cant find env variable `TG_NOTY_CHAT_ID_AWD`');
        }

        parent::__construct();
    }

    /**
     * Perform command
     *
     * @throws GuzzleException
     * @throws Exception
     * @throws Throwable
     */
    protected function perform(): void
    {
        $items = new SimpleXMLElement($this->getMarkup());

        $advertisements = $this->advertisementRepository->findAll();

        foreach ($items->channel->item as $value) {
            if ($this->checkingForDuplicates($advertisements, $value->link) === true) {

                $advertisement = new Advertisement();

                $advertisement->post = $value->link;
                $advertisement->created_at = new DateTimeImmutable();

                $this->tr->persist($advertisement);
                $this->tr->run();

                $this->queue->push(TelegramMessageJob::class, [
                    'chatId' => $this->chatId,
                    'message' => $value->category . PHP_EOL . $value->link
                ]);
            }
        }
    }

    /**
     * @return string
     * @throws GuzzleException
     */
    private function getMarkup(): string
    {
        $response = $this->httpClient->request('GET', $this->url, [
            'query' => [
                'limit' => '1_HOUR',
                'sort_by' => 'standard',
                'feed_type' => 'RSS2.0',
                'feed_style' => 'HTML',
                'max_word_size' => '250'
            ]
        ]);

        return $response->getBody()->getContents();
    }

    /**
     * Проверяем ссылку на дубликат в базе данных
     *
     * @param $data
     * @param $link
     * @return bool
     */
    private function checkingForDuplicates($data, $link): bool
    {
        $key = array_filter($data, function($innerArray) use ($link) {
            return ($innerArray->post == $link);
        });

        return $key === Array();
    }
}
