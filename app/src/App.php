<?php

/**
 * This file is part of Spiral package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App;

use App\Bootloader;
use Spiral\Bootloader as Framework;
use Spiral\DotEnv\Bootloader as DotEnv;
use Spiral\Framework\Kernel;
use Spiral\Monolog\Bootloader as Monolog;
use Spiral\Nyholm\Bootloader as Nyholm;
use Spiral\Prototype\Bootloader as Prototype;
use Spiral\Scaffolder\Bootloader as Scaffolder;
use Spiral\Stempler\Bootloader as Stempler;
use Spiral\Sentry\Bootloader as Sentry;

class App extends Kernel
{
    /*
     * List of components and extensions to be automatically registered
     * within system container on application start.
     */
    protected const LOAD = [
        // Base extensions
        DotEnv\DotenvBootloader::class,
        Monolog\MonologBootloader::class,

        // Application specific logs
        Bootloader\LoggingBootloader::class,

        // Core Services
        Framework\SnapshotsBootloader::class,

        // Security and validation
        Framework\Security\ValidationBootloader::class,
        Framework\Security\FiltersBootloader::class,
        Framework\Security\GuardBootloader::class,

        // HTTP extensions
        Nyholm\NyholmBootloader::class,
        Framework\Http\RouterBootloader::class,
        Framework\Http\ErrorHandlerBootloader::class,
        Framework\Http\JsonPayloadsBootloader::class,

        // Databases
        Framework\Database\DatabaseBootloader::class,
        Framework\Database\MigrationsBootloader::class,

        // ORM
        Framework\Cycle\CycleBootloader::class,
        Framework\Cycle\ProxiesBootloader::class,
        Framework\Cycle\AnnotatedBootloader::class,

        // Views and view translation
        Framework\Views\ViewsBootloader::class,

        // Additional dispatchers
        Framework\Jobs\JobsBootloader::class,

        // Extensions and bridges
        Stempler\StemplerBootloader::class,
        Framework\I18nBootloader::class,

        // Framework commands
        Framework\CommandBootloader::class,
        Scaffolder\ScaffolderBootloader::class,

        // Auth
//        Framework\Auth\HttpAuthBootloader::class,
//        Framework\Auth\TokenStorage\CycleTokensBootloader::class,
//        Framework\Auth\SecurityActorBootloader::class,

        // Debug and debug extensions
//        Sentry\SentryBootloader::class,
        Framework\DebugBootloader::class,
        Framework\Debug\LogCollectorBootloader::class,
        Framework\Debug\HttpCollectorBootloader::class,
    ];

    /*
     * Application specific services and extensions.
     */
    protected const APP = [
        // fast code prototyping
        Prototype\PrototypeBootloader::class,

        Bootloader\RoutesBootloader::class,
        Bootloader\AppBootloader::class,
    ];
}
