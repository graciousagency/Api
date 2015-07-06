<?php


namespace Robin\Api\Models\Views\Details;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Robin\Api\Traits\ModelFormatter;

abstract class Detail implements Arrayable, Jsonable
{
    use ModelFormatter;
}