<?php

require 'vendor/autoload.php';

use Goutte\Client;

$client = new Client();

$books = crawlKosmasBooks($client);

$ticketPortal = crawlTicketPortal($client);

$events = crawlLucernaMusicBar($client);

var_dump($books);
var_dump($ticketPortal);
var_dump($events);

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

function crawlTicketPortal(Client $client) {
    $crawler = $client->request('GET', 'https://www.ticketportal.cz/');

    $events = [];

    $crawler->filter('#timeline_row_0 > div')->each(function ($node) use (&$events) {
        // #timeline_row_0 - tento element je v DOMu ale ne ve zdrojovem kodu
        // content je generovan dynamicky nejspise javascriptem
    });

    return $events;
}

function crawlLucernaMusicBar(Client $client) {
    $crawler = $client->request('GET', 'http://www.lucerna.cz/program/ref_2018-12-04/b1');

    $events = [];

    $crawler->filter('#calendar > li')->each(function ($node) use (&$events) {
        $event = [];
        if (trim($node->filter('.biginfo > ul')->html()) !== '') {
            $timeAndTitle = $node->filter('.biginfo > ul > a > li#event.bar')->html();
            $timeAndTitle = explode(' ', $timeAndTitle, 2);
            $event['time'] = trim($timeAndTitle[0]);
            $event['title'] = trim($timeAndTitle[1]);
            $event['date'] = $node->filter('div.info > div.day')->text();
            try {
                $event['date'] .= ' ' . $node->filter('div.num')->text() . '. ';
            } catch (Exception $e) {
                $event['date'] .= ' ' . $node->filter('div.numne')->text() . '. ';
            }
            $event['date'] .= $node->filter('div.info > div.month')->text();

            $events[] = $event;
        }
    });

    return $events;
}