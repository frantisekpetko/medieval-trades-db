<?php

declare(strict_types=1);
error_reporting(E_ALL);
include(__DIR__ . '/server/app/Utils/utils.php');
require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/server/.env');

use \App\Services\CorsService;
new CorsService();

use App\Database\Database;
new Database();

use App\Services\DebugService;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Debug\ErrorHandler;
Debug::enable();
ErrorHandler::register();
DebugService::register();



date_default_timezone_set(getenv('APP_LOCAL'));
//$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $actual_link;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
$container = new Container;
// Create a request from server variables, and bind it to the container; optional
$request = Request::capture();
$container->instance('Illuminate\Http\Request', $request);
// Using Illuminate/Events/Dispatcher here (not required); any implementation of
// Illuminate/Contracts/Event/Dispatcher is acceptable
$events = new Dispatcher($container);
// Create the router instance
$router = new Router($events, $container);
// Load the routes
// TODO ROUTES
$gen = new UrlGenerator($router->getRoutes(), $request);
//$gen->forceScheme("https");
require_once __DIR__ . "/server/app/Router/mainRouter.php";
// Create the redirect instance
$redirect = new Redirector($gen);
// Dispatch the request through the router
$response = $router->dispatch($request);
// Send the response back to the browser
$response->send();
$routeCollection = $router->getRoutes();



/*
$routes = array_map(function (\Illuminate\Routing\Route $route)
{ return $route->uri;
}, (array)
$router->getRoutes()->getIterator());
var_dump($routes);
*/

