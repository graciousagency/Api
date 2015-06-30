<?php


namespace Robin\Api\Models\Views;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Robin\Api\Traits\ModelFormatter;

class ListView implements Jsonable, Arrayable
{
    use Robin\Api\Traits\ModelFormatter;

    public $orderNumber;

    public $date;

    public $status;

    /**
     * @param $orderNumber
     * @param $date
     * @param $status
     * @return ListView
     */
    public static function make($orderNumber, $date, $status)
    {
        $list = new static();

        $list->orderNumber = $orderNumber;
        $list->date = $date;
        $list->status = $status;

        return $list;
    }
}