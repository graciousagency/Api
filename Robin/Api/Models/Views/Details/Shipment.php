<?php


namespace Robin\Api\Models\Views\Details;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Robin\Api\Traits\ModelFormatter;

class Shipment implements Jsonable, Arrayable
{

    use Robin\Api\Traits\ModelFormatter;

    public $shipment;

    public $status;

    public static function make($shipmentUrl, $status)
    {
        $shipment = new static;
        $shipment->shipment = $shipmentUrl;
        $shipment->status = $status;

        return $shipment;
    }
}