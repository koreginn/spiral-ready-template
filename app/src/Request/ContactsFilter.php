<?php

declare(strict_types=1);

namespace App\Request;

use Spiral\Filters\Filter;

class ContactsFilter extends Filter
{
    public const SCHEMA = [
        'user' => 'data:user',
        'contacts' => [ContactFilter::class]
    ];

    public const VALIDATES = [
      'user' => ['required', 'string'],
      'contacts' => ['required', 'array']
    ];
}
