<?php

require 'vendor/autoload.php';

use Goutte\Client;

$client = new Client();

$books = crawlKosmasBooks($client);

var_dump($books);

function crawlKosmasBooks(Client $client) {
    $crawler = $client->request('GET', 'https://www.kosmas.cz/kategorie/64/?Filters.ArticleTypeIds=3563&name=detektivky/');

    $books = [];

    $crawler->filter('#page1 > div')->each(function ($node) use (&$books) {
        $book = [];
        $book['title'] = trim($node->filter('h3.g-item__title > a')->text());
        $book['author'] = $node->filter('div.g-item__authors > span > a')->text();
        $book['price'] =  $node->filter('div.price__default')->text();
        $books[] = $book;
    });

    return $books;
}