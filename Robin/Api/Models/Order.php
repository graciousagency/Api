<?php


namespace Robin\Api\Models;


use Illuminate\Contracts\Support\Arrayable;
use Robin\Api\Collections\Details as DetailsView;
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
use Robin\Connect\SEOShop\Models\Order as SeoOrder;
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

    public static function make(SeoOrder $SeoOrder)
    {
        $order = new static();
        $order->orderNumber = $SeoOrder->number;
        $order->emailAddress = $SeoOrder->customer->email;
        $order->orderByDate = static::formatDate($SeoOrder->createdAt, "/");
        $order->revenue = (string)$SeoOrder->priceIncl;
        $order->url = $SeoOrder->getEditUrl();

        $order->listView = ListView::make(
            $SeoOrder->number,
            static::formatDate($SeoOrder->createdAt),
            $SeoOrder->status
        );

        $order->detailsView = self::makeDetailViews($SeoOrder);

        return $order;
    }

    /**
     * @param SeoOrder $seoOrder
     * @return Order
     */
    private static function makeDetailViews(SeoOrder $seoOrder)
    {
        $detailsView = new DetailsView();

        $detailsView->push(self::createDetailsView($seoOrder));
        $detailsView->push(self::createProductsView($seoOrder));
        $detailsView->push(self::createShipmentsView($seoOrder));
        $detailsView->push(self::createInvoicesView($seoOrder));
        return $detailsView;
    }


    /**
     * @param SeoOrder $SEOShopOrder
     * @return static
     */
    private static function createDetailsView(SeoOrder $SEOShopOrder)
    {
        $details = OrderDetails::make(
            static::formatDate
            (
                $SEOShopOrder->createdAt
            ),
            $SEOShopOrder->status,
            $SEOShopOrder->paymentStatus,
            $SEOShopOrder->shipmentStatus
        );

        return DetailViewItem::make("details", $details);
    }

    private static function getOrderedProducts(SeoOrder $seoOrder)
    {
        $products = $seoOrder->orderProducts;
        $robinProducts = Products::make();
        foreach ($products as $product) {
            $robinProducts->push(Product::fromSeoShop($product));
        }

        return $robinProducts;
    }

    /**
     * @param SeoOrder $SeoOrder
     * @return DetailViewItem
     */
    private static function createProductsView(SeoOrder $SeoOrder)
    {
        return DetailViewItem::make("columns", static::getOrderedProducts($SeoOrder), "products");
    }

    private static function createShipmentsView(SeoOrder $seoOrder)
    {
        $shipments = $seoOrder->shipments;
        $robinShipments = Shipments::make();
        foreach ($shipments as $shipment) {
            $robinShipments->push(Shipment::make($shipment->getEditUrl(), $shipment->status));
        }
        return DetailViewItem::make("rows", $robinShipments, "Shipments");
    }

    private static function createInvoicesView(SeoOrder $seoOrder)
    {
        $invoices = $seoOrder->invoices;
        $robinInvoices = Invoices::make();
        foreach ($invoices as $invoice) {
            $robinInvoices->push(Invoice::make($invoice->getEditUrl(), $invoice->status, $invoice->priceIncl));
        }
        return DetailViewItem::make("rows", $robinInvoices, "invoices");
    }
}