<?php

declare(strict_types=1);

namespace App\Request;

use Spiral\Filters\Filter;

class SearchByPhoneFilter extends Filter
{
    public const SCHEMA = [
        'phone' => 'query:phone'
    ];

    public const VALIDATES = [
        'phone' => ['required', 'string']
    ];
}
