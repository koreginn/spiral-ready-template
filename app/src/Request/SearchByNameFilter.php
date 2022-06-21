<?php

declare(strict_types=1);

namespace App\Request;

use Spiral\Filters\Filter;

class SearchByNameFilter extends Filter
{
    public const SCHEMA = [
        'search' => 'query:search'
    ];

    public const VALIDATES = [
        'search' => ['required', 'string']
    ];
}
