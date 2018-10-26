<?php

include_once 'autoload.php';

$now = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

$customer = new EShop\Customer(1, "Test");
$order = new EShop\Order(1, $now, $now, $customer, []);
$product = new EShop\Product(1, 'Product', 12.5);

var_dump($customer);
var_dump($order);
var_dump($product);
