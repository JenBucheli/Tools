<?php
require 'Model/Connection.php';
require 'Model/Customer.php';
require 'Model/Product.php';
require 'Loader/CustomerLoader.php';
require 'Loader/ProductLoader.php';
require 'Controller/HomeController.php';
require 'config.php';

require 'View/Includes/header.php';

$controller = new HomeController();

$controller->render($_GET, $_POST);


require 'View/Includes/footer.php';




