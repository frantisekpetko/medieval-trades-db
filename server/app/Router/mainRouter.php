<?php

/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 26.10.2018
 * Time: 20:35
 */
use \App\Controllers\ClientLoggerController;
use App\Services\DebugService;


header('Content-Type: application/json, charset=utf-8');
const API = "api/";


$router->get('/{url}', function () {
    require __DIR__ . "/../../../public/index.html";
})->where('url', '[^/]*');;


$router->get(API . 'app-name', function(){
        echo json_encode( [["appName" => getenv("APP_NAME")]], JSON_PRETTY_PRINT);
});

if (getenv("APP_MODE") === "dev") {
        $router->get(API .'debug/server/exception', function( DebugService $debug){
                $debug->finishSendingRestfulException();
        });
}


if (getenv("APP_MODE") === "dev") {
 
    $router->post( API.'debug/client/error', function(ClientLoggerController $logger){
        $logger->log();
    });

    $router->post( API.'overview/client/error', function(ClientLoggerController $logger){
        $logger->reportErrorLogToClient();
    });


}

/**
 * Subrouter class
 * Which is needed to manage generation of client components or backend class
 */
require_once __DIR__ . '/Subrouter/DevSubrouter/generatorSubrouter.php';

require_once __DIR__ . '/Subrouter/corsSubrouter.php';
require_once __DIR__ . '/Subrouter/welcomeSubrouter.php';
require_once __DIR__ . '/Subrouter/productSubrouter.php';
require_once __DIR__ . '/Subrouter/categorySubrouter.php';
require_once __DIR__ . '/Subrouter/adminSubrouter.php';
require_once __DIR__ . '/Subrouter/orderSubrouter.php';
require_once __DIR__ . '/Subrouter/awdSubrouter.php';
require_once __DIR__ . '/Subrouter/testSubrouter.php';
require_once __DIR__ . '/Subrouter/customersSubrouter.php';
