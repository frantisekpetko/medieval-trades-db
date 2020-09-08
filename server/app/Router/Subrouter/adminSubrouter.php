<?php


/*
use Swift_Mailer;
use Swift_Transport;
$transport = new Swift_Tran;
$mailer = new Swift_Mailer($transport);
*/
use  App\Controllers\Eshop\Auth\AdminController;

$admin = new AdminController();

/*
$router->get( API.'adminsrc', function (AdminController $adminsrc ){
    $adminsrc->index();
});


$router->get( API.'adminsrc/{id}', function ($id, AdminController $adminsrc ){
    $adminsrc->single($id);
});
*/

$router->post( API.'admin/register', function ( AdminController $admin ){
    $admin->register();
});

$router->post( API.'admin/login', function ( AdminController $admin ){
    $admin->login();
});

$router->post( API.'admin/logout', function ( AdminController $admin ){
    $admin->logout();
});

$router->get( API.'admin/auth', function ( AdminController $admin ){
    $admin->auth();
});

/*
$router->patch( API.'adminsrc/{id}', function ($id, AdminController $adminsrc ){
    $adminsrc->update($id);
});


$router->delete( API.'adminsrc/{id}', function ($id, AdminController $adminsrc ){
    $adminsrc->erase($id);
});
*/
