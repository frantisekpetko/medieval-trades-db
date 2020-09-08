<?php

use App\Controllers\TestController;

$test = new TestController(
    //new \App\Models\Test(new \App\Database\Connection())
);


$router->get( API.'test', function (TestController $test ){
    $test->index();
});


$router->get( API.'test/{id}', function ($id, TestController $test ){
    $test->single($id);
});


$router->post( API.'test', function ( TestController $test ){
    $test->store();
});


$router->patch( API.'test/{id}', function ($id, TestController $test ){
    $test->update($id);
});


$router->delete( API.'test/{id}', function ($id, TestController $test ){
    $test->erase($id);
});

