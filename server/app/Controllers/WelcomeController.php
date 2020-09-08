<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 06.01.2019
 * Time: 11:56
 */

namespace App\Controllers;

class WelcomeController extends RestController
{
    public function index()
    {
        parent::sendJSON(
            [[
                "phpVersion" => (float)phpversion(),
                "scaffoldingVersion" =>  getenv('SCAFFOLDING_VERSION'),
            ]]
        );
    }
}