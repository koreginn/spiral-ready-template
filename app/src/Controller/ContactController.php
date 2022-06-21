<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database\Contact;
use App\Helper\Helper;
use App\Job\UploadContactJob;
use App\Repository\ContactRepository;
use App\Request\ContactsFilter;
use App\Request\SearchByNameFilter;
use App\Request\SearchByPhoneFilter;
use Cycle\ORM\Select\QueryBuilder;
use Psr\Http\Message\ResponseInterface;
use Spiral\Database\Query\SelectQuery;
use Spiral\Http\ResponseWrapper;
use Spiral\Jobs\QueueInterface;
use Spiral\Models\Exception\EntityExceptionInterface;

class ContactController extends Controller
{
    /** @var QueueInterface */
    private QueueInterface $queue;

    /** @var ContactRepository $contactRepository */
    private ContactRepository $contactRepository;

    public function __construct(
        ResponseWrapper $response,
        QueueInterface $queue,
        ContactRepository $contactRepository
    ) {
        $this->queue = $queue;
        $this->contactRepository = $contactRepository;

        parent::__construct($response);
    }

    /**
     * @throws EntityExceptionInterface
     */
    public function upload(ContactsFilter $request): ResponseInterface
    {
        $chunkContacts = array_chunk($request->getField('contacts'), 100);

        $jobIds = [];

        foreach ($chunkContacts as $contacts) {
            $jobIds[] = $this->queue->push(UploadContactJob::class, [
                'user' => $request->getField('user'),
                'contacts' => $contacts
            ]);
        }

        return $this->response->json([
            'jobsIds' => $jobIds
        ], 200);
    }

    /**
     * @throws EntityExceptionInterface
     */
    public function search(SearchByPhoneFilter $request): ResponseInterface
    {
        $phone = Helper::formattingPhone($request->getField('phone'));

        $tags = [];

        $contacts = $this->contactRepository->findAll([
           'phone' => ['like' => "%{$phone}%"]
        ]);

        /** @var Contact $contact */
        foreach ($contacts as $contact) {
            $tags[] = $contact->getFullName();
        }

        return $this->response->json($tags, 200);
    }

    /**
     * @throws EntityExceptionInterface
     */
    public function searchAll(SearchByNameFilter $request): ResponseInterface
    {
        $name = $request->getField('search');

        $contacts = $this->contactRepository->select()
            ->where('user', '!=', 'system')
            ->where(
                static function (QueryBuilder $select) use ($name) {
                    $select
                        ->where('last_name', 'like', "%{$name}%")
                        ->orWhere('first_name', 'like', "%{$name}%");
                }
            )
            ->orderBy('created_at', 'DESC')
            ->fetchAll();

        return $this->response->json($contacts, 200);
    }

    public function count(): ResponseInterface
    {
        return $this->response->json([
            'value' => $this->contactRepository->select()->where('user', '!=', 'system')->count()
        ]);
    }

    public function last(): ResponseInterface
    {
        $contacts = $this->contactRepository->select()
            ->orderBy('created_at', 'DESC')
            ->limit(500)
            ->fetchAll();

        return $this->response->json($contacts, 200);
    }
}
