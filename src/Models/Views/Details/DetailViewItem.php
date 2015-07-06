<?php


namespace Robin\Api\Models\Views\Details;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use Robin\Api\Traits\ModelFormatter;

class DetailViewItem extends Detail
{

    public $displayAs;

    public $caption;
    /**
     * @var Collection
     */
    public $data;


    public static function make($displayAs, $data, $caption = '')
    {
        $detail = new static;

        $detail->displayAs = $displayAs;

        $detail->data = $data;

        $detail->caption = $caption;

        return $detail;
    }
}