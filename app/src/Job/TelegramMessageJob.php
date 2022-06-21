<?php

declare(strict_types=1);

namespace App\Job;

use App\Exception\EnvironmentError;
use GuzzleHttp\Exception\GuzzleException;
use Spiral\Boot\EnvironmentInterface;
use Spiral\Core\FactoryInterface;
use Spiral\Core\ResolverInterface;
use Spiral\Jobs\JobHandler;
use GuzzleHttp\Client;
use Spiral\Jobs\QueueInterface;

class TelegramMessageJob extends JobHandler
{
    public const TOO_MANY_REQUESTS_CODE = 429;

    /** @var FactoryInterface */
    private FactoryInterface $factory;

    /** @var EnvironmentInterface */
    private EnvironmentInterface $env;

    /** @var Client */
    private Client $httpClient;

    /** @var QueueInterface */
    private QueueInterface $queue;

    /** @var string */
    private $hostTelegram;

    /**
     * @throws EnvironmentError
     */
    public function __construct(ResolverInterface $resolver, FactoryInterface $factory)
    {
        $this->factory = $factory;
        $this->env = $this->factory->make(EnvironmentInterface::class);
        $this->queue = $this->factory->make(QueueInterface::class);
        $this->hostTelegram = $this->env->get('TG_NOTY_HOST');
        $this->httpClient = new Client([
            'allow_redirects' => false,
            'exceptions' => false
        ]);

        if (boolval($this->hostTelegram) === false) {
            throw new EnvironmentError('Cant find env variable `TG_NOTY_HOST`');
        }

        parent::__construct($resolver);
    }

    /**
     * Send a notification to the Telegram channel
     *
     * @param string $chatId
     * @param string $message
     * @throws GuzzleException
     */
    public function invoke(string $chatId, string $message): void
    {
        $response = $this->httpClient->request('GET', "$this->hostTelegram/sendMessage", [
            'query' => [
                'chat_id' => $chatId,
                'parse_mode' => 'Markdown',
                'text' => $message
            ]
        ]);

        if ($response->getStatusCode() === self::TOO_MANY_REQUESTS_CODE) {
            $this->queue->push(TelegramMessageJob::class, [
                'chatId' => $chatId,
                'message' => $message
            ]);
        }
    }
}
