<?php


namespace Robin\Api\Models;


use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Robin\Api\Collections\DetailsView as DetailsView;
use Robin\Api\Collections\Products;
use Robin\Api\Collections\Shipments;
use Robin\Api\Models\Views\Details\DetailViewItem;
use Robin\Api\Models\Views\Details\Invoice;
use Robin\Api\Models\Views\Details\OrderDetails;
use Robin\Api\Models\Views\Details\Product;
use Robin\Api\Models\Views\Details\Shipment;
use Robin\Api\Models\Views\ListView;
use Robin\Api\Traits\DateFormatter;
use Robin\Api\Traits\ModelFormatter;
use Robin\Api\Collections\Invoices;
use Illuminate\Contracts\Support\Jsonable;

class Order implements Jsonable, Arrayable
{
    use ModelFormatter;
    use DateFormatter;

    public $orderNumber;

    public $emailAddress;

    public $url;

    public $orderByDate;

    public $revenue;

    /**
     * @var ListView
     */
    public $listView;

    /**
     * @var DetailsView
     */
    public $detailsView;

    public static function make(
        $number,
        $email,
        Carbon $createdAt,
        $price,
        $editUrl,
        ListView $listView,
        DetailsView $detailsView
    ) {
        $order = new static();
        $order->orderNumber = $number;
        $order->emailAddress = $email;
        $order->orderByDate = static::formatDate($createdAt, "/");
        $order->revenue = (string)$price;
        $order->url = $editUrl;

        $order->listView = $listView;

        $order->detailsView = $detailsView;

        return $order;
    }
}