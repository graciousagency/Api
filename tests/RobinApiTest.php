<?php

use GuzzleHttp\Psr7\Response;
use Monolog\Logger;
use Robin\Api\Collections\Customers;
use Robin\Api\Logger\RobinLogger;
use Robin\Api\Robin;
use Robin\Api\Collections\Orders;

class RobinApiTest extends TestCase
{


    public function testCanSendCustomer()
    {
        $api = $this->getRealRobinClient();

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

    /**
     * @expectedException \Robin\Api\Exceptions\RobinSendFailedException
     */
    public function testThrowsExceptionWhenRequestFails()
    {
        $api = $this->getRealRobinClient();

        $api->customers(Customers::make(['this' => "should", 'trigger' => 'an', 'error']));
    }
}