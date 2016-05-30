<?php


namespace Robin\Api\Models\Views\Details;


class Product extends Detail
{

    public $product;

    public $quantity;

    public $price;

//    public $variantTitle;

    public static function make($name, $quantity, $price, $variantTitle)
    {
        $product = new static;

        $product->product = $name.' ('.$variantTitle.')';

        $product->quantity = (string)$quantity;

        $product->price = (string)$price;

//        $product->variantTitle = $variantTitle;

        return $product;
    }
}