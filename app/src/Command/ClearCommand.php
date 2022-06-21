<?php

declare(strict_types=1);

namespace App\Command;

use App\Repository\AdvertisementRepository;
use Cycle\ORM\TransactionInterface;
use Spiral\Console\Command;
use Throwable;

class ClearCommand extends Command
{
    protected const NAME = 'clear:table';

    protected const DESCRIPTION = 'Clearing the database';

    /** @var AdvertisementRepository */
    private AdvertisementRepository $advertisementRepository;

    /** @var TransactionInterface $tr */
    private TransactionInterface $tr;

    /**
     * Constructor
     */
    public function __construct(AdvertisementRepository $advertisementRepository, TransactionInterface $tr) {
        $this->advertisementRepository = $advertisementRepository;
        $this->tr = $tr;

        parent::__construct();
    }

    /**
     * Perform command
     * @throws Throwable
     */
    protected function perform(): void
    {
        $this->clearAdvertisements();
    }

    /**
     * @throws Throwable
     */
    private function clearAdvertisements()
    {
        $advertisements = $this->advertisementRepository->findAll();

        foreach ($advertisements as $advertisement) {
            $this->tr->delete($advertisement);
            $this->tr->run();
        }
    }
}
