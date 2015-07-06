<?php


use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Robin\Api\Robin;
use Robin\Api\Logger\RobinLogger;

class TestCase extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Filesystem
     */
    private $filesystem;


    public function getRobin()
    {
        $key = env('ROBIN_API_KEY');
        $secret = env('ROIBIN_API_SECRET');
        $url = env('ROBIN_API_URL');

        $monolog = new Logger("ROBIN");
        $logger = new RobinLogger($monolog);

        return new RobinLogger($key, $secret, $url, $logger);
    }

    protected function setUp()
    {
        $this->filesystem = new Filesystem(new Local(__DIR__));
    }

    public function getModel($model, $decode = false)
    {
        $content = $this->filesystem->read("/models/" . $model . ".json");
        return ($decode) ? json_decode($content, true) : $content;
    }

    public function getLog()
    {
        return $this->filesystem->read('logs/robin.log');
    }

    public function deleteLog()
    {
        $this->filesystem->delete('logs/robin.log');
    }

    protected function getRealRobinClient()
    {
        $key = env("ROBIN_API_KEY");
        $secret = env("ROIBIN_API_SECRET");
        $url = env("ROBIN_API_URL");

        $monolog = new Logger("ROBIN");
        $monolog->pushHandler(new StreamHandler(__DIR__ . '/logs/robin.log'));

        $robinLogger = new RobinLogger($monolog);
        return new Robin($key, $secret, $url, $robinLogger);

    }
}