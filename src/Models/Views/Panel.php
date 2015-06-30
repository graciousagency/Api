<?php


namespace Robin\Api\Models\Views;

use Illuminate\Contracts\Support\Arrayable;
use Robin\Api\Traits\ViewFormatter;
use Illuminate\Contracts\Support\Jsonable;

class Panel implements Jsonable, Arrayable
{
    use ViewFormatter;

    public $orders;

    public $totalSpent;

    public static function make($orders, $totalSpend)
    {
        $panel = new static;

        $panel->orders = (string)$orders;

        $panel->totalSpent = $totalSpend;

        return $panel;
    }
}