<?php


namespace Robin\Api\Models\Views\Details;


class Invoice
{

    public $shipment;

    public $status;

    public $amount;

    public static function make($url, $status, $amount)
    {
        $invoice = new static;

        $invoice->shipment = $url;
        $invoice->status = $status;
        $invoice->amount = (string)$amount;

        return $invoice;
    }
}