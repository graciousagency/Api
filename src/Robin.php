<?php


namespace Robin\Api;


use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Collection;
use Robin\Api\Exceptions\RobinSendFailedException;
use Robin\Api\Logger\RobinLogger;
use Robin\Support\Contracts\Sender;
use Robin\Api\Collections\Customers;
use Robin\Api\Collections\Orders;

class Robin implements Sender
{
    private $url;
    private $key;
    private $secret;
    /**
     * @var GuzzleClient
     */
    private $client;
    /**
     * @var RobinLogger
     */
    private $errorLogger;

    /**
     *
     * @param $key
     * @param $secret
     * @param $url
     * @param RobinLogger $errorLogger
     */
    public function __construct($key, $secret, $url, RobinLogger $errorLogger)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->url = $url;

        $client = new GuzzleClient(['base_uri' => $url, 'auth' => [$key, $secret]]);
        $this->setClient($client);
        $this->errorLogger = $errorLogger;
    }

    public function orders(Orders $orders)
    {
        return $this->post('orders', $orders);
    }

    public function customers(Customers $customers)
    {

        return $this->post("customers", $customers);

    }

    private function post($endPoint, Collection $data)
    {
        try {
            return $this->client->post($endPoint, ['json' => $data->toJson()]);
        } catch (ClientException $exception) {
            $sendFailedException = new RobinSendFailedException();
            $sendFailedException->setResponse($exception->getResponse());
            throw $sendFailedException;
        }

    }

    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }
}