<?php

require 'vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use EShop\Model\Product;
use EShop\Model\Customer;
use EShop\Middleware\AuthMiddleware;

$app = new \Slim\App();

function checkBody($body, $name, &$errors) {
    if (!$body[$name]) {
        $errors[] = 'Missing field ' . $name;
    }
    return $body[$name];
}

// Products
$app->get('/products', function (Request $request, Response $response, $args) {
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

$app->get('/products/{id}', function (Request $request, Response $response, $args) {
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

// Customers
$app->post('/customers', function (Request $request, Response $response, $args) {
    $parsedBody = $request->getParsedBody();
    $errors = [];
    checkBody($parsedBody, 'name', $errors);
    checkBody($parsedBody, 'username', $errors);
    checkBody($parsedBody, 'password', $errors);

    if (!empty($errors)) {
        return $response->withHeader('Content-type', 'application/json')->withJson([
            'errors' => $errors,
        ], 400);
    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(201);
});

$app->get('/customer/current', function(Request $request, Response $response, $args) {
    $customer = $request->getAttribute('customer');
    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson([
        'name' => $customer->getName(),
        'username' => $customer->getUsername(),
    ]);
})->add(new AuthMiddleware());

// Run app
$app->run();