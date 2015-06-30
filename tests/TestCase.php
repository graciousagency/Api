<?php


use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Robin\Api\Client;

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

        return new Client($key, $secret, $url);
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
}