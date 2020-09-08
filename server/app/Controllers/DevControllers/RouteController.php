<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 24.03.2019
 * Time: 2:00
 */

namespace App\Controllers\DevControllers;

use App\Controllers\RestApi;
use App\Controllers\RestController;

class RouteController extends RestController
{


    const ROUTE_TEMPLATE_STORE_PATH = '/../../Console/ComponentFactory/PlainTemplateStore/DummySubrouter/';
    const PREGENERATED_ROUTE_FILE = '/../../Router/Subrouter/base.stub';

    const REST_CONTROLLER_TEMPLATE_PATH = '/../../Console/ComponentFactory/ClassTemplateStore/DummyRestController.stub';
    const PREGENERATED_CONTROLLER_FILE = '/../../Controllers/DummyRestController.stub';

    private $modelName;
    private $lowercaseModel;
    private $preview;
    private $controllerPreview;

    public function sendRouteSubrouterPreview()
    {
        parent::sendJSON(["preview" => $this->preview, "controllerPreview" => $this->controllerPreview ]);
    }


    public function finishGenerateRouteSubrouter()
    {    
        $data = parent::receiveJSON();
        $route = $data["name"];
        rename(__DIR__ . static::PREGENERATED_ROUTE_FILE, __DIR__ . '/../../Router/Subrouter/'. $route . "Subrouter.php" );
        rename(__DIR__ . static::PREGENERATED_CONTROLLER_FILE, __DIR__ . '/../../Controllers/'. \ucfirst($route) . "Controller.php" );
       
        $import =  "require_once __DIR__ . '/Subrouter/". $route  ."Subrouter.php';";

        $genFile= file_put_contents(__DIR__ . '/../../Router/mainRouter.php', $import.PHP_EOL, FILE_APPEND | LOCK_EX);

        
    }

    public function generateRestController()
    {
        copy( __DIR__ . static::REST_CONTROLLER_TEMPLATE_PATH, __DIR__ .static::PREGENERATED_CONTROLLER_FILE);
        
        $str = file_get_contents(__DIR__ . static::PREGENERATED_CONTROLLER_FILE);
        $str = str_replace('DummyModel', $this->modelName, $str);
        $str = str_replace('DummyRest', $this->modelName, $str);
        $str = str_replace('dummyModel', $this->lowercaseModel, $str);
        file_put_contents(__DIR__ . static::PREGENERATED_CONTROLLER_FILE, "");
        $genFile= file_put_contents(__DIR__ . static::PREGENERATED_CONTROLLER_FILE, $str.PHP_EOL, FILE_APPEND | LOCK_EX);
        $this->controllerPreview = $str;
        
    }


    public function cancelOperation()
    {
        unlink(__DIR__ . static::PREGENERATED_ROUTE_FILE);
        unlink(__DIR__ . static::PREGENERATED_CONTROLLER_FILE);
    }


    public function generateRouteSubrouter()
    {
        $data = parent::receiveJSON();
        $path = $data["path"];

        $actionIndex = $data["actionIndex"];
        $actionSingle = $data["actionSingle"];
        $actionStore = $data["actionStore"];
        $actionUpdate = $data["actionUpdate"];
        $actionErase = $data["actionErase"];

        $controllerCreation = $data["controllerCreation"];
        $modelAssociation = $data["modelAssociation"];
        $this->modelName = $data["modelName"];
        $this->lowercaseModel =  strtolower($this->modelName);
        $this->generateRestController();
        
        if(copy( __DIR__ . static::ROUTE_TEMPLATE_STORE_PATH . 'blank.stub', __DIR__ .static::PREGENERATED_ROUTE_FILE ))
        {

            $strBase = file_get_contents(__DIR__ . static::ROUTE_TEMPLATE_STORE_PATH . 'base.stub');
            $strBase = str_replace('dummyModel', $this->lowercaseModel, $strBase);
            $strBase = str_replace('DummyController', $this->modelName . "Controller", $strBase);
            $strBase = str_replace('DummyModel', $this->modelName, $strBase);

            $genFile= file_put_contents(__DIR__ . static::PREGENERATED_ROUTE_FILE, $strBase.PHP_EOL, FILE_APPEND | LOCK_EX);

            $strIndex = file_get_contents(__DIR__ . static::ROUTE_TEMPLATE_STORE_PATH . 'getCollection.stub');
            $strIndex = str_replace('_generatedPath', $path, $strIndex);
            $strIndex = str_replace('DummyController', $this->modelName . "Controller", $strIndex);
            $strIndex = str_replace('dummyControl', $this->lowercaseModel, $strIndex);
            $strIndex = str_replace('dummyControl', $this->lowercaseModel, $strIndex);

            $genFile= file_put_contents(__DIR__ . static::PREGENERATED_ROUTE_FILE, $strIndex.PHP_EOL, FILE_APPEND | LOCK_EX);

            $strSingle = file_get_contents(__DIR__ . static::ROUTE_TEMPLATE_STORE_PATH . 'getResource.stub');
            $strSingle = str_replace('_generatedPath', $path, $strSingle);
            $strSingle = str_replace('DummyController', $this->modelName . "Controller", $strSingle);
            $strSingle = str_replace('dummyControl', $this->lowercaseModel, $strSingle);
            $strSingle = str_replace('dummyControl', $this->lowercaseModel, $strSingle);

            $genFile= file_put_contents(__DIR__ . static::PREGENERATED_ROUTE_FILE, $strSingle.PHP_EOL, FILE_APPEND | LOCK_EX);

            $strStore = file_get_contents(__DIR__ . static::ROUTE_TEMPLATE_STORE_PATH . 'postResource.stub');
            $strStore = str_replace('_generatedPath', $path, $strStore);
            $strStore = str_replace('DummyController', $this->modelName . "Controller", $strStore);
            $strStore = str_replace('dummyControl', $this->lowercaseModel, $strStore);
            $strStore = str_replace('dummyControl', $this->lowercaseModel, $strStore);
  

            $genFile= file_put_contents(__DIR__ . static::PREGENERATED_ROUTE_FILE, $strStore.PHP_EOL, FILE_APPEND | LOCK_EX);

            $strUpdate = file_get_contents(__DIR__ . static::ROUTE_TEMPLATE_STORE_PATH . 'patchResource.stub');
            $strUpdate = str_replace('_generatedPath', $path, $strUpdate);
            $strUpdate = str_replace('DummyController', $this->modelName . "Controller", $strUpdate);
            $strUpdate = str_replace('dummyControl', $this->lowercaseModel, $strUpdate);
            $strUpdate = str_replace('dummyControl', $this->lowercaseModel, $strUpdate);


            $genFile= file_put_contents(__DIR__ . static::PREGENERATED_ROUTE_FILE, $strUpdate.PHP_EOL, FILE_APPEND | LOCK_EX);

            $strErase = file_get_contents(__DIR__ . static::ROUTE_TEMPLATE_STORE_PATH . 'deleteResource.stub');
            $strErase = str_replace('_generatedPath', $path, $strErase);
            $strErase = str_replace('DummyController', $this->modelName . "Controller", $strErase);
            $strErase = str_replace('dummyControl', $this->lowercaseModel, $strErase);
            $strErase = str_replace('dummyControl', $this->lowercaseModel, $strErase);


            $genFile= file_put_contents(__DIR__ . static::PREGENERATED_ROUTE_FILE, $strErase.PHP_EOL, FILE_APPEND | LOCK_EX);
            
            $finalStr = file_get_contents(__DIR__ . static::PREGENERATED_ROUTE_FILE);
            $this->preview = $finalStr;  
        }

        $this->sendRouteSubrouterPreview();
        

    }

}