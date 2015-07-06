<?php


namespace Robin\Api\Exceptions;


use GuzzleHttp\Psr7\Response;

class RobinException extends \Exception
{
    /**
     * @var Response
     */
    private $response;

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }
}