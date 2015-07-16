<?php


namespace Robin\Api\Logger;


use Illuminate\Support\Collection;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Robin\Api\Models\Customer;
use Robin\Api\Models\Order;

class RobinLogger
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
        $logger->pushProcessor(new IntrospectionProcessor());
    }

    public function hooksError($payload, $request)
    {
        $this->logger->addCritical("Error while receiving a web-hook.", compact("payload", "request"));
    }

    public function hooksInfo($payload, $request)
    {
        $this->logger->addInfo("Processing incoming web-hook: ", compact("payload", "request"));
    }

    /**
     * @param Customer|Order $model
     * @param $reason
     * @param $message
     */
    public function makeError($model, $reason, $message)
    {
        $this->logger->addCritical("Failed making a ROBIN Model", compact("model", "reason", "message"));
    }

    /**
     * @param Collection $models
     * @param $reason
     * @param $message
     * @param $primitive
     */
    public function sendError(Collection $models, $reason, $message, $primitive)
    {
        $this->logger->addCritical(
            "Failed sending the following Customer objects to ROBIN: ",
            compact("models", "reason", "message", "primitive")
        );
    }
}