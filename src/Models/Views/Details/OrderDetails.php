<?php


namespace Robin\Api\Models\Views\Details;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Robin\Api\Traits\ModelFormatter;

class OrderDetails implements Arrayable, Jsonable
{

    use ModelFormatter;

    public $date;

    public $status;

    public $paymentStatus;

    public $shipmentStatus;

    public static function make($date, $status, $paymentStatus, $shipmentStatus)
    {
        $details = new static;

        $details->date = $date;
        $details->status = $status;
        $details->paymentStatus = $paymentStatus;
        $details->shipmentStatus = $shipmentStatus;

        return $details;
    }

}