<?php

include_once __DIR__ . '/../autoload.php';

$now = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

$customer1 = new EShop\Model\Customer(1, "Testovaci 1");
$customer2 = new EShop\Model\Customer(2, "Testovaci 2");
$customer3 = new EShop\Model\Customer(3, "Testovaci 3");
$customer4 = new EShop\Model\Customer(4, "Testovaci 4");
$customer5 = new EShop\Model\Customer(5, "Testovaci 5");

$product1 = new EShop\Model\Product(1, 'Product 1', 12.5, 0.21);
$product2 = new EShop\Model\Product(2, 'Product 2', 12.5, 0.21);
$product3 = new EShop\Model\Product(3, 'Product 3', 12.5, 0.21);
$product4 = new EShop\Model\Product(4, 'Product 4', 12.5, 0.15);
$product5 = new EShop\Model\Product(5, 'Product 5', 12.5, 0.21);

$order1 = new EShop\Model\Order(1, $now, $now, $customer1, [
    $product1,
    $product3
]);

$order2 = new EShop\Model\Order(2, $now, $now, $customer4, [
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