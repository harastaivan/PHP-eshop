<?php

include_once __DIR__ . '/../autoload.php';

$now = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

$customer1 = new EShop\Customer(1, "Testovaci 1");
$customer2 = new EShop\Customer(2, "Testovaci 2");
$customer3 = new EShop\Customer(3, "Testovaci 3");
$customer4 = new EShop\Customer(4, "Testovaci 4");
$customer5 = new EShop\Customer(5, "Testovaci 5");

$product1 = new EShop\Product(1, 'Product 1', 12.5);
$product2 = new EShop\Product(2, 'Product 2', 12.5);
$product3 = new EShop\Product(3, 'Product 3', 12.5);
$product4 = new EShop\Product(4, 'Product 4', 12.5);
$product5 = new EShop\Product(5, 'Product 5', 12.5);

$order1 = new EShop\Order(1, $now, $now, $customer1, [
    $product1,
    $product3
]);

$order2 = new EShop\Order(2, $now, $now, $customer4, [
    $product2,
    $product3,
    $product5
]);

$order1->addItem($product1);
$order1->removeItem($product3);

print_r($customer1);
print_r($customer2);
print_r($customer3);
print_r($customer4);
print_r($customer5);

print_r($product1);
print_r($product2);
print_r($product3);
print_r($product4);
print_r($product5);

print_r($order1);
print_r($order2);