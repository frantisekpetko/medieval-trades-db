<?php

use App\Controllers\CustomersController;

$customers = new CustomersController(
    //new \App\Models\Customers(new \App\Database\Connection())
);


$router->get( API.'customers', function (CustomersController $customers ){
    $customers->index();
});


$router->get( API.'customers/{id}', function ($id, CustomersController $customers ){
    $customers->single($id);
});


$router->post( API.'customers', function ( CustomersController $customers ){
    $customers->store();
});


$router->patch( API.'customers/{id}', function ($id, CustomersController $customers ){
    $customers->update($id);
});


$router->delete( API.'customers/{id}', function ($id, CustomersController $customers ){
    $customers->erase($id);
});

