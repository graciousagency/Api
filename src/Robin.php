<?php


namespace Robin\Api;


use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;
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
     *
     * @param $key
     * @param $secret
     * @param $url
     */
    public function __construct($key, $secret, $url)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->url = $url;

        $client = new GuzzleClient(['base_uri' => $url, 'auth' => [$key, $secret]]);
        $this->setClient($client);
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
        return $this->client->post($endPoint, ['json' => $data->toJson()]);
    }

    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }
}