<?php
namespace Robin\Api\Contracts;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Robin\Api\Collections\Customers;
use Robin\Api\Collections\Orders;

interface Sender
{
    /**
     * @param Orders $orders
     * @return Response
     */
    public function orders(Orders $orders);

    /**
     * @param Customers $customers
     * @return Response
     */
    public function customers(Customers $customers);

    public function setClient(ClientInterface $client);
}