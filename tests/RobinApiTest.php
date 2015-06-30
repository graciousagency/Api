<?php


use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use Robin\Connect\Contracts\Retriever;
use Robin\Connect\Contracts\Sender;
use Robin\Connect\Robin\Api\Client;
use Robin\Connect\Robin\Collections\Orders;
use Robin\Connect\Robin\Models\Customer;
use Robin\Connect\Robin\Models\Order;

class RobinApiTest extends TestCase
{


    public function testCanSendCustomer()
    {
        $key = env("ROBIN_API_KEY");
        $secret = env("ROIBIN_API_SECRET");
        $url = env("ROBIN_API_URL");

        $api = new Client($key, $secret, $url);

        $customers = new \Robin\Connect\Robin\Collections\Customers(
            [
                [
                    "email_address" => "bwubs@me.com",
                    "customer_since" => "2013-12-23",
                    "order_count" => 5,
                    "total_spent" => "$78.00",
                    "currency" => "USD",
                    "name" => "Bram Wubs",
                    "phone_number" => "0612345678",
                    "twitter_name" => "bwubs",
                    "panel_view" => [
                        'Orders' => "12",
                        "Total_spent" => "$78.00"
                    ]
                ],
                [
                    "email_address" => "petrischilder@hotmail.com",
                    "customer_since" => "2015-06-22",
                    "order_count" => 1,
                    "total_spent" => "€29.95",
                    "panel_view" => [
                        "Orders" => "1",
                        "Total_spent" => "€29.95"
                    ]
                ]
            ]
        );
        $response = $api->customers($customers);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testSendOrders()
    {
        $api = $this->getRealRobinClient();

        $order = $this->getModel("robin_order", true);

        $orders = new Orders(
            [
                $order
            ]
        );

        $response = $api->orders($orders);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('201', $response->getStatusCode());

    }

    private function getRealRobinClient()
    {
        $key = env("ROBIN_API_KEY");
        $secret = env("ROIBIN_API_SECRET");
        $url = env("ROBIN_API_URL");

        return new Client($key, $secret, $url);

    }
}

class TestApi implements Sender
{

    /**
     * @var GuzzleHttp\Client
     */
    private $client;

    public function orders(Orders $orders)
    {
        // TODO: Implement orders() method.
    }

    /**
     * @param \Robin\Connect\Robin\Collections\Customers $customers
     * @return Response|void
     */
    public function customers(\Robin\Connect\Robin\Collections\Customers $customers)
    {

        $this->client->post("customers", $customers->toArray());
    }

    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }
}