<?php

use App\Controllers\Eshop\Resource\CategoryController;

$category = new CategoryController();


$router->get( API.'category', function (CategoryController $category ){
    $category->index();
});


$router->get( API.'category/{id}', function ($id, CategoryController $category ){
    $category->single($id);
});


$router->post( API.'category', function ( CategoryController $category ){
    $category->store();
});


$router->patch( API.'category/{id}', function ($id, CategoryController $category ){
    $category->update($id);
});


$router->delete( API.'category/{id}', function ($id, CategoryController $category ){
    $category->erase($id);
});

