<?php


namespace Robin\Api\Exceptions;


class RobinSendFailedException extends RobinException
{
    private $message = "Failed sending the given models to ROBIN";

}