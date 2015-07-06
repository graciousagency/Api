<?php


use Carbon\Carbon;
use Robin\Api\Models\Customer;
use Robin\Api\Models\Views\Panel;

class RobinCustomerTest extends TestCase
{


    public function testCustomerModelCanBeCreated()
    {
        $since = Carbon::createFromFormat("Y-m-d", "2013-04-21", new DateTimeZone("Europe/Amsterdam"));
        $panel = new Panel();
        $panel->make("5", "1150");
        $robinCustomer = Customer::make("bwubs@me.com", $since, 5, "€1150,-", $panel);

        $this->assertInstanceOf(Customer::class, $robinCustomer);
        $this->assertEquals("2013-04-21", $robinCustomer->customerSince);
    }
}