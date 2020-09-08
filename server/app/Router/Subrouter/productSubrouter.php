<?php

use App\Controllers\Eshop\Resource\ProductController;

$product = new ProductController();


$router->get( API.'product', function (ProductController $product ){
    $product->index();
});

$router->get( API.'product/{limit}/paginate', function ($id, ProductController $product ){
    $product->pagination($id);
});


$router->get( API.'product/{id}', function ($id, ProductController $product ){
    $product->single($id);
});


$router->post( API.'product', function ( ProductController $product ){
    $product->store();
});


$router->patch( API.'product/{id}', function ($id, ProductController $product ){
    $product->update($id);
});


$router->delete( API.'product/{id}', function ($id, ProductController $product ){
    $product->erase($id);
});

