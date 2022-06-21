<?php

namespace App\Controller;

use Spiral\Http\ResponseWrapper;

/**
 * Class Controller
 *
 * @package App\Controller
 */
abstract class Controller
{

    /**
     * @var ResponseWrapper
     */
    protected $response;

    /**
     * Constructor
     *
     * @param ResponseWrapper $response
     */
    public function __construct(ResponseWrapper $response)
    {
        $this->response = $response;
    }
}
