<?php


use Carbon\Carbon;
use Robin\Api\Collections\Products;
use Robin\Api\Collections\Shipments;
use Robin\Api\Models\Order;
use Robin\Api\Collections\DetailsView;
use Robin\Api\Collections\Invoices;
use Robin\Api\Models\Views\Details\Invoice;
use Robin\Api\Models\Views\Details\OrderDetails;
use Robin\Api\Models\Views\Details\Product;
use Robin\Api\Models\Views\Details\DetailViewItem;
use Robin\Api\Models\Views\Details\Shipment;
use Robin\Api\Models\Views\ListView;

class RobinOrderTest extends TestCase
{


    public function testFormatsOrderDate()
    {
        $robinOrder = $this->getRobinOrder();

        $this->assertEquals("2015/06/25", $robinOrder->orderByDate);
        $this->assertEquals(
            "https://seoshop.webshopapp.com/backoffice/sales-orders/edit?id=7846544",
            $robinOrder->url
        );
    }

    public function testAddsListViewToOrder()
    {
        $robinOrder = $this->getRobinOrder();

        $this->assertInstanceOf(ListView::class, $robinOrder->listView);
        $this->assertArrayHasKey("order_number", $robinOrder->listView->toArray());
    }

    public function testAddsDetailsViewToOrder()
    {
        $robinOrder = $this->getRobinOrder();

        $this->assertInstanceOf(DetailsView::class, $robinOrder->detailsView);
        /** @var DetailViewItem $detail */
        $detail = $robinOrder->detailsView->first();
        $this->assertInstanceOf(DetailViewItem::class, $detail);
        $this->assertArrayHasKey("display_as", $detail->toArray());
        $this->assertEquals("details", $detail->displayAs);
        $this->assertInstanceOf(OrderDetails::class, $detail->data);

    }

    public function testAddsProductsToDetailsView()
    {
        $robinOrder = $this->getRobinOrder();

        $products = Products::make();
        $products->push(Product::make("iStuff", 1, "€12,50"));

        $robinOrder->detailsView->addColumns($products, "products");
        /** @var DetailViewItem $productsView */
        $productsView = $robinOrder->detailsView->get(1);

        $this->assertInstanceOf(DetailViewItem::class, $productsView);
        $this->assertArrayHasKey("display_as", $productsView->toArray());
        $this->assertEquals("columns", $productsView->displayAs);

        $this->assertInstanceOf(Product::class, $productsView->data->first());
    }

    public function testAddsShipmentsToDetailsView()
    {
        $robinOrder = $this->getRobinOrder();

        $shipments = Shipments::make();

        $shipments->push(Shipment::make("#", "Shipped"));

        $robinOrder->detailsView->addRows($shipments, "Shipments");

        $shipmentsView = $robinOrder->detailsView->get(1);

        $this->assertInstanceOf(DetailViewItem::class, $shipmentsView);
        $this->assertArrayHasKey("display_as", $shipmentsView->toArray());
        $this->assertEquals("rows", $shipmentsView->displayAs);
    }

    public function testAddsInvoicesToDetailsView()
    {
        $robinOrder = $this->getRobinOrder();

        $invoices = Invoices::make();

        $invoices->push(Invoice::make("#", "Paid", "12,50"));

        $robinOrder->detailsView->addRows($invoices, "Invoices");

        $shipmentsView = $robinOrder->detailsView->get(1);

        $this->assertInstanceOf(DetailViewItem::class, $shipmentsView);
        $this->assertArrayHasKey("display_as", $shipmentsView->toArray());
        $this->assertEquals("rows", $shipmentsView->displayAs);
        $this->assertInstanceOf(Invoices::class, $shipmentsView->data);
        $this->assertInstanceOf(Invoice::class, $shipmentsView->data->first());
    }

    /**
     * @return Order
     */
    private function getRobinOrder()
    {


        $createdAt = Carbon::now(new DateTimeZone("Europe/Amsterdam"))->subDays(5);
        $listView = ListView::make("ORD123", $createdAt, "Shipped");

        $detailsView = new DetailsView();
        $orderDetails = OrderDetails::make($createdAt, "Shipped", "Paid", "Shipped");
        $detailsView->addDetails($orderDetails);

        return Order::make(
            "ORD1234",
            "bwubs@me.com",
            $createdAt,
            12.50,
            "https://seoshop.webshopapp.com/backoffice/sales-orders/edit?id=7846544",
            $listView,
            $detailsView
        );
    }

}