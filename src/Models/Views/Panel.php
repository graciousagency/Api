<?php


namespace Robin\Api\Models\Views;

use Illuminate\Contracts\Support\Arrayable;
use Robin\Api\Traits\ViewFormatter;
use Illuminate\Contracts\Support\Jsonable;

class Panel implements Jsonable, Arrayable
{
    use ViewFormatter;

//    public $orders;

    public $totalSpent;

    public $billingCountry;

    public static function make($orders, $totalSpent, $billingCountry)
    {
        $panel = new static;

//        $panel->orders = (string)$orders;

        $panel->totalSpent = $totalSpent;
        $panel->billingCountry = $billingCountry;

        return $panel;
    }
}