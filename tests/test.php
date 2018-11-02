<?php
use EShop\Model\Customer;
use EShop\Model\Product;
use EShop\Model\Order;
use EShop\Model\UnregisteredCustomer;
use EShop\Model\RegisteredCustomer;

use Symfony\Component\Validator\Validation;

require __DIR__ . '/../vendor/autoload.php';

$now = new \DateTime();

// Customer
$customer1 = new Customer("Testovaci 1");
$customer2 = new Customer("Testovaci 2");
$customer3 = new Customer("Testovaci 3");
$customer4 = new Customer("Testovaci 4");
$customer5 = new Customer("Testovaci 5");

// Customer Id
if ($customer1->getId() !== 1 || $customer2->getId() !== 2 || $customer5->getId() !== 5) {
    throw new \Exception('wrong customer Id');
}

// Product
$product1 = new Product('Product 1', 12.5, 0.21);
$product2 = new Product('Product 2', 12.5, 0.21);
$product3 = new Product('Product 3', 12.5, 0.21);
$product4 = new Product('Product 4', 12.5, 0.15);
$product5 = new Product('Product 5', 12.5, 0.21);

// Product Id
if ($product1->getId() !== 1 || $product2->getId() !== 2 || $product5->getId() !== 5) {
    throw new \Exception('wrong product Id');
}

// Order
$order1 = new Order($now, $customer1, [
    $product1,
    $product3
]);

$order2 = new Order($now, $customer4, [
    $product2,
    $product3,
    $product5
]);

// Order Id
if ($order1->getId() !== 1 || $order2->getId() !== 2) {
    throw new \Exception('wrong order Id');
}

// Add | Remove item from order
$order1->addItem($product1);
$order1->removeItem($product3);


// Price Vat
$product6 = new Product('Product 6', 1000, 0.24);
if ($product6->getPriceVat() != 1240) {
    throw new \Exception('wrong getPriceVat');
}

// Unregistered | Registered Customer
$customerWillBeRegistered = new UnregisteredCustomer('Budu registrovany');
$customerWillNotBeRegistered = new UnregisteredCustomer('Nebudu registrovany');

$customerIsRegistered = $customerWillBeRegistered->register();

if (!$customerIsRegistered instanceof RegisteredCustomer) {
    throw new \Exception('wrong register');
}

if ($customerIsRegistered->getLoyaltyPoints() != RegisteredCustomer::REGISTRATION_LOYALTY_POINTS) {
    throw new \Exception('wrong loyalty points when registered');
}

// Order
$orderFromRegisteredCustomer = new Order($now, $customerIsRegistered, [
    $product1,
    $product6
]);

if (!$orderFromRegisteredCustomer->getCustomer() instanceof RegisteredCustomer) {
    throw new \Exception('customer not registered');
}

$orderFromRegisteredCustomer->doOrder();

if ($orderFromRegisteredCustomer->getOrdered() == null) {
    throw new \Exception('wrong ordered date after doOrder');
}

if ($customerIsRegistered->getLoyaltyPoints() != 1255.125 * RegisteredCustomer::LOYALTY_POINTS_COEFFICIENT + RegisteredCustomer::REGISTRATION_LOYALTY_POINTS) {
    throw new \Exception('wrong loyalty points after doOrder');
}

if ($customerWillBeRegistered->getName() !== $customerIsRegistered->getName()) {
    throw new \Exception('unregistered customer name didnt stay the same when became registered');
}

$validator = Validation::createValidatorBuilder()
    ->addMethodMapping('loadValidatorMetadata')
    ->getValidator();

$customerWithBlankName = new Customer("");
$productWithBlankName = new Product("", 10, 0.2);
$productWithNegativePrice = new Product("product", -1, 0.2);
$productWithNegativeVatRate = new Product("produkt", 12.5, -0.01);
$productWithGreaterThanOneVatRate = new Product("product", 50, 1.01);
$productWithZeroVatRate = new Product("product", 50, 0);
$productWithOneVatRate = new Product("product", 50, 1);

$errors = $validator->validate([
    $customerWithBlankName,
    $productWithBlankName,
    $productWithNegativePrice,
    $productWithNegativeVatRate,
    $productWithGreaterThanOneVatRate,
    $productWithZeroVatRate,
    $productWithOneVatRate,
]);

echo (string) $errors;


//print_r($customer1);
//print_r($customer2);
//print_r($customer3);
//print_r($customer4);
//print_r($customer5);

//print_r($product1);
//print_r($product1->getPriceVat());
//print_r($product2);
//print_r($product2->getPriceVat());
//print_r($product3);
//print_r($product3->getPriceVat());
//print_r($product4);
//print_r($product4->getPriceVat());
//print_r($product5);
//print_r($product5->getPriceVat());

//print_r($order1);
//print_r($order2);

//print_r($customerWillNotBeRegistered);
//print_r($customerWillBeRegistered);
//print_r($customerIsRegistered);