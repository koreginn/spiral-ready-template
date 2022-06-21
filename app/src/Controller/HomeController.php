<?php

/**
 * This file is part of Spiral package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Spiral\Http\Exception\ClientException\NotFoundException;
use Spiral\Prototype\Traits\PrototypeTrait;
use OpenApi\Annotations as OA;

class HomeController extends Controller
{
    use PrototypeTrait;

    /**
     * @OA\Get(
     *     path="/home",
     *     summary="Something about this endpoint",
     *     tags={"Test queries"},
     *     @OA\Response(response="200", description="JSON answer example")
     * )
     */
    public function index(): ResponseInterface
    {
        return $this->response->json(['no.chat']);
    }

    /**
     * @OA\Get(
     *     path="/home/ping",
     *     summary="Something about this endpoint",
     *     tags={"Test queries"},
     *     @OA\Response(response="200", description="JSON answer example")
     * )
     */
    public function ping(): ResponseInterface
    {
        $jobID = $this->queue->push(Ping::class, [
            'value' => 'hello world',
        ]);

        return $this->response->json(['jobID' => $jobID]);
    }

    /**
     * @OA\Get(
     *     path="/home/exception",
     *     summary="Something about this endpoint",
     *     tags={"Test queries"},
     *     @OA\Response(response="404", description="JSON answer example")
     * )
     */
    public function exception(): ResponseInterface
    {
        throw new NotFoundException('Test');
    }
}
