<?php

declare(strict_types=1);

namespace App\Middleware\Error;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Spiral\Http\ErrorHandler\RendererInterface;

/**
 * Class Handler
 *
 * @package App\Component\Error
 */
class Handler implements RendererInterface
{

    /** @var ResponseFactoryInterface $responseFactory */
    private $responseFactory;

    /**
     * Handler constructor.
     *
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * @inheritDoc
     */
    public function renderException(Request $request, int $code, string $message): Response
    {
        $response = $this->responseFactory->createResponse($code);

        $response->getBody()->write(json_encode(['error' => $message]));

        return $response->withStatus($code, $message);
    }
}
