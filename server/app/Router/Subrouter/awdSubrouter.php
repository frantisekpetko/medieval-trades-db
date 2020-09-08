<?php

use App\Controllers\AwdController;

$awd = new AwdController(
    //new \App\Models\Awd(new \App\Database\Connection())
);


$router->get( API.'awd', function (AwdController $awd ){
    $awd->index();
});


$router->get( API.'awd/{id}', function ($id, AwdController $awd ){
    $awd->single($id);
});


$router->post( API.'awd', function ( AwdController $awd ){
    $awd->store();
});


$router->patch( API.'awd/{id}', function ($id, AwdController $awd ){
    $awd->update($id);
});


$router->delete( API.'awd/{id}', function ($id, AwdController $awd ){
    $awd->erase($id);
});

