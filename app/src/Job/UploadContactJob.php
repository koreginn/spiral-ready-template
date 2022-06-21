<?php

declare(strict_types=1);

namespace App\Job;

use App\Database\Contact;
use App\Helper\Helper;
use App\Repository\ContactRepository;
use Cycle\ORM\TransactionInterface;
use DateTimeImmutable;
use Spiral\Core\FactoryInterface;
use Spiral\Core\ResolverInterface;
use Spiral\Jobs\JobHandler;
use Spiral\Prototype\Traits\PrototypeTrait;
use Throwable;

class UploadContactJob extends JobHandler
{
    /** @var FactoryInterface $factory */
    private FactoryInterface $factory;

    /** @var TransactionInterface $tr */
    private TransactionInterface $tr;

    /** @var ContactRepository $contactRepository */
    private $contactRepository;

    use PrototypeTrait;

    public function __construct(ResolverInterface $resolver, FactoryInterface $factory)
    {
        $this->factory = $factory;
        $this->tr = $this->factory->make(TransactionInterface::class);
        $this->contactRepository = $this->factory->make(ContactRepository::class);

        parent::__construct($resolver);
    }

    /**
     * @param string $user
     * @param array $contacts
     * @throws Throwable
     */
    public function invoke(string $user, array $contacts)
    {
        foreach ($contacts as $contact) {
            if (empty($contact['phoneNumber']) === false) {
                $phone = Helper::formattingPhone($contact['phoneNumber']);

                $contactFromDB = $this->contactRepository->findOne([
                    'last_name' => $contact['lastName'],
                    'first_name' => $contact['firstName'],
                    'phone' => $phone
                ]);

                if (is_null($contactFromDB) === true) {
                    $newContact = new Contact();

                    $newContact->last_name = $contact['lastName'];
                    $newContact->first_name = $contact['firstName'];
                    $newContact->phone = $phone;
                    $newContact->email = $contact['email'];
                    $newContact->user = $user;
                    $newContact->created_at = new DateTimeImmutable();

                    $this->tr->persist($newContact);
                    $this->tr->run();
                }
            }
        }
    }

    public function serialize(string $jobType, array $payload): string
    {
        $contacts = [];

        foreach ($payload['contacts'] as $contact) {
            $contacts[] = $contact->getFields();
        }

        $payload['contacts'] = $contacts;

        return parent::serialize($jobType, $payload);
    }
}
