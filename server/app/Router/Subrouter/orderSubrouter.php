<?php


use App\Controllers\Eshop\Resource\OrderController;

$router->post(API . 'order', function (OrderController $order) {
    $order->provideOrder();
});

