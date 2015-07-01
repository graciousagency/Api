<?php

use GuzzleHttp\Psr7\Response;
use Robin\Api\Collections\Customers;
use Robin\Api\Robin;
use Robin\Api\Collections\Orders;

class RobinApiTest extends TestCase
{


    public function testCanSendCustomer()
    {
        $key = env("ROBIN_API_KEY");
        $secret = env("ROIBIN_API_SECRET");
        $url = env("ROBIN_API_URL");

        $api = new Robin($key, $secret, $url);

        $customers = new Customers(
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

        $order = $this->getModel("order", true);

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

        return new Robin($key, $secret, $url);

    }
}