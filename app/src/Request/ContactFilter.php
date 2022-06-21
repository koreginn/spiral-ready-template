<?php

declare(strict_types=1);

namespace App\Request;

use Spiral\Filters\Filter;

class ContactFilter extends Filter
{
    public const SCHEMA = [
        'email' => 'data:email',
        'lastName' => 'data:lastName',
        'firstName' => 'data:firstName',
        'phoneNumber' => 'data:phoneNumber'
    ];

    public const VALIDATES = [
        'email' => ['string'],
        'lastName' => ['string'],
        'firstName' => ['string'],
        'phoneNumber' => ['string']
    ];
}

