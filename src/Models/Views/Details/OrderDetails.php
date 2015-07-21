<?php


namespace Robin\Api\Models\Views\Details;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Robin\Api\Traits\DateFormatter;
use Robin\Api\Traits\ModelFormatter;

class OrderDetails extends Detail
{
    use DateFormatter;

    public $date;

    public $status;

    public $paymentStatus;

    public $shipmentStatus;

    public static function make($date, $status, $paymentStatus, $shipmentStatus)
    {
        $details = new static;

        $details->date = static::formatDate($date);
        $details->status = $status;
        $details->paymentStatus = $paymentStatus;
        $details->shipmentStatus = $shipmentStatus;

        return $details;
    }

}