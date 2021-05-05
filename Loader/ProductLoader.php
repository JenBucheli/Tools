<?php


class ProductLoader //extends Connection
{
    public static function getProduct(int$id, Pdo $pdo): Product
    {
        $query=$pdo->prepare('select * from product where id= :id');
        $query->bindValue('id', $id);
        $query->execute();
        $rawProduct = $query->fetch();
        //var_dump();
        return Product::loadProductDatabase($id, $rawProduct['name'], $rawProduct['price']);
    }


    public static function getAllProducts(Pdo $pdo): array
    {
        $query = $pdo->query('select * from product ORDER BY name');
        $query->execute();
        $raw_products = $query->fetchAll();


        $products = [];
        foreach ($raw_products as ['id' => $id, 'name' => $name, 'price' => $price]) {
            $products[] = Product::loadProductDatabase(
                $id,
                $name,
                $price
            );
        }
        return $products;
    }
}
