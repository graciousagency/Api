<?php


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Robin\Api\Collections\Customers;
use Robin\Api\Collections\Orders;
use Robin\Api\Logger\RobinLogger;

class RobinLoggerTest extends TestCase
{


    public function testLogsToFile()
    {
        $monolog = new Logger("ROBIN");
        $monolog->pushHandler(new StreamHandler(__DIR__ . '/logs/robin.log'));
        $monolog->pushProcessor(new IntrospectionProcessor());
        $logger = new RobinLogger($monolog);

        $logger->sendError(new Orders(), 500, "Missing Data", ['blaat' => 'blaat']);

        $content = $this->getLog();

        $this->assertContains('blaat', $content);

        $this->deleteLog();
    }
}