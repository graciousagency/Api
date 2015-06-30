<?php


use Robin\Connect\Contracts\Logger;
use Robin\Connect\Contracts\Retriever;
use Robin\Connect\Robin\Collections\Details;
use Robin\Connect\Robin\Collections\Invoices;
use Robin\Connect\Robin\Collections\Products;
use Robin\Connect\Robin\Models\Order;
use Robin\Connect\Robin\Models\Views\Details\Invoice;
use Robin\Connect\Robin\Models\Views\Details\Product;
use Robin\Connect\Robin\Models\Views\Details\DetailViewItem;
use Robin\Connect\SEOShop\Api\Resource;

class RobinOrderTest extends TestCase
{


    public function testFormatsOrderDate()
    {
        $robinOrder = $this->getRobinOrder();

        $this->assertEquals("2015/06/08", $robinOrder->orderByDate);
        $this->assertEquals(
            "https://seoshop.webshopapp.com/backoffice/sales-orders/edit?id=7846544",
            $robinOrder->url
        );
    }

    public function testAddsListViewToOrder()
    {
        $robinOrder = $this->getRobinOrder();

        $this->assertInstanceOf('Robin\\Connect\\Robin\\Models\\Views\\ListView', $robinOrder->listView);
        $this->assertArrayHasKey("order_number", $robinOrder->listView->toArray());
    }

    public function testAddsDetailsViewToOrder()
    {
        $robinOrder = $this->getRobinOrder();

        $this->assertInstanceOf(Details::class, $robinOrder->detailsView);
        /** @var DetailViewItem $detail */
        $detail = $robinOrder->detailsView->first();
        $this->assertInstanceOf(DetailViewItem::class, $detail);
        $this->assertArrayHasKey("display_as", $detail->toArray());
        $this->assertEquals("details", $detail->displayAs);
        $this->assertInstanceOf(\Robin\Connect\Robin\Models\Views\Details\OrderDetails::class, $detail->data);

    }

    public function testAddsProductsToDetailsView()
    {
        $robinOrder = $this->getRobinOrder();

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

        $shipmentsView = $robinOrder->detailsView->get(2);

        $this->assertInstanceOf(DetailViewItem::class, $shipmentsView);
        $this->assertArrayHasKey("display_as", $shipmentsView->toArray());
        $this->assertEquals("rows", $shipmentsView->displayAs);
    }

    public function testAddsInvoicesToDetailsView()
    {
        $robinOrder = $this->getRobinOrder();

        $shipmentsView = $robinOrder->detailsView->get(3);

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
        $seoOrder = $this->getModel("order");
        $client = new SeoDummyClient();
        $seoOrder = (new Robin\Connect\SEOShop\Models\Order($client))->makeFromJson(
            $seoOrder
        );
        return Order::make($seoOrder);
    }

}

class SeoDummyClient implements Retriever
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
        if (is_object($resource) && is_string($name)) {
            $name = ucfirst($name);
            return (new Resource($resource, $this, $name))->get();
        }
        return json_decode(
            json_encode(
                [
                    "email" => 'blaat@blaat.com'
                ]
            )
        );
    }

    public function getNumRetrieved()
    {
        return 0;
    }

    public function count($endpoint)
    {
        // TODO: Implement count() method.
    }
}