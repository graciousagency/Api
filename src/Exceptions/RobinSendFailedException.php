<?php


namespace Robin\Api\Exceptions;


class RobinSendFailedException extends RobinException
{
    protected $message = "Failed sending the given models to ROBIN";

}