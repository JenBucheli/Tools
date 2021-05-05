<?php


class HomeController
    // connect to DB
{
    private Connection $db;

    public function __construct() {
        $this->db = new Connection;
    }

    public function render(array $GET, array $POST){

        $customers = CustomerLoader::getAllCustomers($this->db);
        $products = ProductLoader::getAllProducts($this->db);
        require 'View/homepage.php';
    }

    //public function showPrice(array$GET,array$Post){


    //product
    //customer
    //calculator

}

