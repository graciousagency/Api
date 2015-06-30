<?php


namespace Robin\Api\Models\Views\Details;


use Robin\Connect\SEOShop\Models\OrderProduct;

class Product
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

    public static function fromSeoShop(OrderProduct $product)
    {
//        dump($product);
        return static::make($product->productTitle, $product->quantityOrdered, $product->priceIncl);
    }
}