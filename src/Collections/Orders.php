<?php


namespace Robin\Api\Collections;


use Illuminate\Support\Collection;

class Orders extends Collection
{

    public function toArray()
    {
        return ['orders' => parent::toArray()];
    }
}