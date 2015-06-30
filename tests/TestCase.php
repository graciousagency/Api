<?php


use Robin\Api\Client;

class TestCase extends \PHPUnit_Framework_TestCase
{

    public function getRobin()
    {
        $key = env('ROBIN_API_KEY');
        $secret = env('ROIBIN_API_SECRET');
        $url = env('ROBIN_API_URL');

        return new Client($key, $secret, $url);
    }
}