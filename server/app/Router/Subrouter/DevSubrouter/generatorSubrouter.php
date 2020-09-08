<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 07.01.2019
 * Time: 20:52
 */


/*
 *  Model Generation route part
 */

use \App\Controllers\DevControllers\ModelController;

$router->post(API . 'model', function (
    ModelController $model) {
    $model->generateModelClass();
});

$router->post(API . 'model/finish', function (
   ModelController $model
) {
    $model->finishGenerateModelClass();
});

$router->post(API . 'model/cancel', function (
    ModelController $model
) {
    $model->cancelOperation();
});

/*
 *  Migration Generation route part
 */

use  \App\Controllers\DevControllers\MigrationController;

$router->post(API . 'migration', function (
   MigrationController $migration
) {

    $migration->generateMigrationClass();
});

$router->post(API . 'migration/finish', function (
    MigrationController $migration
) {
    $migration->finishGenerateMigrationClass();
});

$router->post(API . 'migration/cancel', function (
    MigrationController $migration
) {
    $migration->cancelOperation();
});


/*
 *  Routing generation route part
 */

use \App\Controllers\DevControllers\RouteController;

$router->post(API . 'route', function (
    RouteController $route
) {
    $route->generateRouteSubrouter();
});

$router->post(API . 'route/finish', function (
   RouteController $route
) {
    $route->finishGenerateRouteSubrouter();
});

$router->post(API . 'route/cancel', function (
    RouteController $route
) {
    $route->cancelOperation();
});


/*
 * Relationship generation route part
 */


use \App\Controllers\DevControllers\RelationshipController;

$router->get(API . 'relationship/search', function (
    RelationshipController $relationship
) {
    $relationship->getAvailableCollectionNamesOfModels();
});

$router->post(API . 'relationship/create', function (
    RelationshipController $relationship
) {
    $relationship->generateRelationshipBetweenEntities();
});

use \App\Controllers\DevControllers\DatabaseAssistantController;

$router->post(API . 'database/cleanup', function (
    DatabaseAssistantController $assistant
) {
    $assistant->cleanUpDatabase();
});


$router->post(API . 'database/migrationup', function (
    DatabaseAssistantController $assistant
) {
    $assistant->runAllMigrations();
});

$router->post(API . 'database/seedup', function (
    DatabaseAssistantController $assistant
) {
    $assistant->runAllSeeds();
});

use App\Controllers\DevControllers\DevDatabaseInitController;

$router->post(API . 'dev/database/init', function (
    DevDatabaseInitController $init
) {
    $init->initDatabase();
});


