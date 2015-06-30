<?php


use Carbon\Carbon;
use Robin\Api\Models\Customer;
use Robin\Api\Models\Views\Panel;

class RobinCustomerTest extends TestCase
{


    public function testCustomerModelCanBeCreated()
    {
        $since = Carbon::now(new DateTimeZone("Europe/Amsterdam"))->subYears(2)->subMonths(2)->subDays(9);
        $panel = new Panel();
        $panel->make("5", "1150");
        $robinCustomer = Customer::make("bwubs@me.com", $since, 5, "€1150,-", $panel);

        $this->assertInstanceOf(Customer::class, $robinCustomer);

    }
}