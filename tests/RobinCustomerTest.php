<?php


use Illuminate\Support\Collection;
use Robin\Connect\Contracts\Retriever;
use Robin\Connect\SEOShop\Collections\Orders;
use Robin\Connect\SEOShop\Models\Customer;
use Robin\Connect\SEOShop\Models\Order;

class RobinCustomerTest extends TestCase
{


    public function testCustomerModelCanBeCreatedFromSEOShopModel()
    {
        $customer = $this->getModel("customer");

        $customer = (new Customer(new MockRetriever()))->makeFromJson($customer);

        $robinCustomer = \Robin\Connect\Robin\Models\Customer::make($customer);

        $this->assertInstanceOf(\Robin\Connect\Robin\Models\Customer::class, $robinCustomer);

    }
}

class MockRetriever implements Retriever
{

    public function customers()
    {
        // TODO: Implement customers() method.
    }

    public function orders()
    {
        // TODO: Implement orders() method.
    }

    public function retrieve($resource, $name = null)
    {
        return new Orders(
            new Collection(
                [

                ]
            )
        );
    }

    public function getNumRetrieved()
    {
        // TODO: Implement getNumRetrieved() method.
    }

    public function count($endpoint)
    {
        // TODO: Implement count() method.
    }
}