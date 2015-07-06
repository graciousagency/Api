<?php


namespace Robin\Api\Models\Views\Details;


class Product extends Detail
{

    public $product;

    public $quantity;

    public $price;

    public static function make($name, $quantity, $price)
    {
        $product = new static;

        $product->product = $name;

        $product->quantity = (string)$quantity;

        $product->price = (string)$price;

        return $product;
    }
}