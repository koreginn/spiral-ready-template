<?php

declare(strict_types=1);

namespace App\Bootloader;

use App\Middleware\Error\Handler;
use Spiral\Bootloader\DomainBootloader;
use Spiral\Bootloader\Http\ErrorHandlerBootloader;
use Spiral\Core\CoreInterface;
use Spiral\Domain\CycleInterceptor;
use Spiral\Domain\FilterInterceptor;
use Spiral\Domain\GuardInterceptor;
use Spiral\Http\ErrorHandler\RendererInterface;

/**
 * Class AppBootloader
 *
 * @package App\Bootloader
 */
class AppBootloader extends DomainBootloader
{
    public const DEPENDENCIES = [
        ErrorHandlerBootloader::class
    ];

    protected const SINGLETONS = [
        CoreInterface::class => [self::class, 'domainCore'],
        RendererInterface::class => Handler::class
    ];

    protected const INTERCEPTORS = [
        FilterInterceptor::class,
        CycleInterceptor::class,
        GuardInterceptor::class,
    ];
}
