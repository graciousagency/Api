<?php


namespace Robin\Api\Collections;


use Illuminate\Support\Collection;

class Customers extends Collection
{

    public function toArray()
    {
        return ['customers' => parent::toArray()];
    }

}