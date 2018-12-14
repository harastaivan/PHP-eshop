<?php

require 'vendor/autoload.php';

use EShop\Model\Product;
use EShop\Model\Customer;

$app = new \Slim\App();

// Products
$app->get('/products', function ($request, $response, $args) {
    $products = [
        new Product('Penezenka', 500, 0.21, 1),
        new Product('Mobil', 15000, 0.21, 2),
        new Product('Klice', 100, 0.21, 3),
    ];
    $data = [];

    foreach ($products as $product) {
        $data[] = $product->getAssocData();
    }
    return $response->withHeader('Content-type', 'application/json')->withJson($data, 200);
});

$app->get('/products/{id}', function ($request, $response, $args) {
    $products = [
        new Product('Penezenka', 500, 0.21, 1),
        new Product('Mobil', 15000, 0.21, 2),
        new Product('Klice', 100, 0.21, 3),
    ];
    $id = $args['id'];

    foreach ($products as $product) {
        if ($product->getId() == $id) {
            return $response->withHeader('Content-type', 'application/json')->withJson($product->getAssocData(), 200);
        }
    }
    return $response->withHeader('Content-type', 'application/json')->withJson([], 404);
});

// Run app
$app->run();