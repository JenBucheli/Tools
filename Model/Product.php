<?php


class Product
{
    private int $product_ID;
    private string $name;
    private int $price;
    private int $id;

    public function __construct(int $product_ID, string $name, int $price)
    {
        $this->product_ID = $product_ID;
        $this->name = $name;
        $this->price = $price;
    }

    public static function loadProductDatabase(int $id, string $name, int $price): Product
    {
        $product = new Product($id, $name, $price);
        $product->id = $id;
        return $product;
    }

    /**
     * @return int
     */
    public function getProduct_ID()
    {
        return $this->product_ID;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int|string
     */
    public function getPrice()
    {
        return $this->price;
    }
}
