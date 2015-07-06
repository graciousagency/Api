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

### Orders

The order object for the ROBIN API is a bit harder to understand due to the way the API expects the data to be given.
 A order is made in the following way:
 
 ```PHP
 <?php
  Order::make(
         $number,
         $email,
         $createdAt,
         $price,
         $editUrl,
         $listView,
         $detailsView
     );
 ```
 
 where `$listView` is an instance of the `ListView` class and `$detailsView` an instance of the `DetailsView` class. 
 To read more about these two objects, please revert to the ROBIN API docs. 
 
 A `ListView` is the object that represents the data when the order is viewed inside a list. This object contains the
  order-number, -date and -status. Creating a ListView is done like this:
    
```PHP
<?php
use Robin\Api\Models\Views\ListView;

$listView = ListView::make($orderNumber, $date, $status);

```
    
Thus far, it's not that hard. The harder part comes when we are going to add the details view to the robin order.
Inside the details view, there can be any kind of object. This library comes with `OrderDetails`, `Products`, 
`Invoices` and`Shipment` details.

To create these details, first we have to create the `DetailsView` collection that contains all of the details.

```PHP
<?php
use Robin\Api\Collections\DetailsView;

$detailsView = new DetailsView();

```

Next create the order details and add them to the `DetailsView`

```PHP
<?php
use Robin\Api\Models\Views\Details\OrderDetails;

$orderDetails = OrderDetails::make($date, $status, $paymentStatus, $shipmentStatus);
$detailsView->addDetails($orderDetails);
```

This will add a `DetailsViewItem` with `OrderDetails` as it's data to the `DetailsView`. The `DetailsViewItem` will 
be displayed as `details`.

When you convert a `detailViewItem` to Json or an Array, they get formatted like this:

```JSON
{
  "display_as":"details",
  "caption":"",
  "data":{
    "date":"16-05-2015",
    "status":"processing",
    "payment_status":"paid",
    "shipment_status:"shipped"
  }
}
```

All public properties are converted to snake case, as this is what the ROBIN API expects.

To add product details, simply do the following:

```PHP
<?php

$products = new Products();

$product = Product::make($product->title, $product->quantity, $product->price);

$products->push($product);

$detailsView->addColumns($products, "Products");
```

This works the same for `Invoices` and `Shipments` details.

## Creating your own details

The ROBIN API allows you to send your own data towards it. The code blow shows you how to do this.

``PHP
<?php
use Robin\Api\Models\Views\Details\Detail;
        
class CustomDetailsView extends Detail
{

    public $fooBar;

    public $barFoo;

    public static function make($foo, $bar)
    {
        $view = new static;

        $view->fooBar = $foo;
        $view->barFoo = $bar;

        return $view;
    }
   
}

$details = new DetailsView();
$custom = CustomDetailsView::make("foo", "bar");
$details->addColumns($custom, "Dummy");

$json = $details->toJson(); // {"display_as":"columns","caption":"Dummy","data":{"foo_bar":"foo","bar_foo":"bar"}}

```




