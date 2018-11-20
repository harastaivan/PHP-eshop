<?php
use EShop\Model\Customer;
use EShop\Model\Product;
use EShop\Model\Order;
use EShop\Model\UnregisteredCustomer;
use EShop\Model\RegisteredCustomer;
use EShop\Logger;
use EShop\Model\ActiveRecord;

use Symfony\Component\Validator\Validation;

require __DIR__ . '/../vendor/autoload.php';

$now = new \DateTime();

// Customer
$customer1 = new UnregisteredCustomer("Alois");

// Product
$product1 = new Product('Product 1', 12.5, 0.21);
$product2 = new Product('Product 2', 10.5, 0.21);

// Order
$order1 = new Order($now, $customer1, [
    $product1,
    $product2,
]);

$order2 = new Order($now, $customer1, [
    $product2
]);

$validator = Validation::createValidatorBuilder()
    ->addMethodMapping('loadValidatorMetadata')
    ->getValidator();

$errors = $validator->validate([
    $customer1,
    $product1,
    $product2,
    $order1,
]);

if (count($errors) > 0) {
    Logger::logWarning('validation errors', [
        $errors,
    ]);
}

ActiveRecord::setDb(new \PDO('sqlite:eshop.db'));

Customer::createDbTable();
Product::createDbTable();
Order::createDbTable();

$product1->insert();
$product2->insert();

$customer1->insert();

$customer1 = $customer1->register();
$customer1->update();

$customers = Customer::all();
print_r($customers);

$alois = Customer::find(1);
print_r($alois);

// this does not work!
// $order1->insert();

$order2->insert();