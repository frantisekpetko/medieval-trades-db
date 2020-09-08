<?php

use App\Controllers\WelcomeController;

$router->get(API . 'welcome', function (WelcomeController $welcome) {
    $welcome->index();
});

