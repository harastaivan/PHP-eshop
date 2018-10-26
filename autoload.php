<?php

spl_autoload_register(function ($className) {
    $class = str_replace('\\', '/', $className);
    $path = str_replace('EShop', 'src', $class);
    include_once(__DIR__ . '/' . $path . '.php');
});