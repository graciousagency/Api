ROBIN API Wrapper
=================

This library wraps the ROBIN Api behind a user friendly interface.

### The basics

In essence, this library can send customers and orders from your e-commerse solution straight into ROBIN. The ROBIN 
API expects these customers and orders to be formatted in a specific way, this can also help you to transform 
your internal order and customer objects to the objects ROBIN understand.


### Objects

The ROBIN API expects two different collections of objects, being customers and orders. Below I'll explain how to 
create both objects.
 
## Customer

To make a ROBIN Customer object, all you need to do is the following:

```PHP
<?php
use Robin\Api\Models\Customer;
use Robin\Api\Views\Panel;

$panel = Panel::make($totalOrders, $totalSpend);
$robinCustomer = Customer::make($email, $customerSince, $ordersCount, $totalSpent, $panel);
```

To send a customer (or a collection of customers) you should always make a Customers collection:
 
```PHP
<?php

$robinCustomer = //...

$customers = new Robin\Api\Collections\Customers([$robinCustomer]);

```

Now, you can send the collection of customers to ROBIN with the following line of code:

```PHP
<?php
//...

$robin = new Robin\Api\Robin($key, $secret, $url);

$response = $robin->customers($customers); //returns Psr\Http\Message\ResponseInterface

```

So, to combine everything:

```PHP
<?php
use Robin\Api\Robin;
use Robin\Api\Models\Customer;
use Robin\Api\Views\Panel;
use Robin\Api\Collections\Customers;

$robin = new Robin($key, $secret, $url);
$panel = Panel::make($totalOrders, $totalSpend);
$robinCustomer = Customer::make($email, $customerSince, $ordersCount, $totalSpend, $panel);
$customers = new Customers([$robinCustomer]);

$response = $robin->customers($customers);
```

The Customers collection makes it really easy to send more customers to ROBIN. Just loop over your existing customers 
and keep pushing ROBIN Customers into the Customers collection, like so:

```PHP
<?php
use Robin\Api\Robin;
use Robin\Api\Models\Customer;
use Robin\Api\Views\Panel;
use Robin\Api\Collections\Customers;

$robin = new Robin($key, $secret, $url);
$shopCustomers = $shop->allCustomers();
$robinCustomers = new Customers();

foreach($shopCustomers as $shopCustomer){
    $panel = Panel::make($shopCustomer->totalOrders, $shopCustomer->totalSpend);
    $robinCustomer = Customer::make(
        $shopCustomer->email, 
        $shopCustomer->createdAt,
        $shopCustomer->totalOrders, 
        $shopCustomer->totalSpend, 
        $panel
    );
    $robinCustomers->push($robinCustomer);
    
    $response = $robin->customers($robinCustomers);
}
```



