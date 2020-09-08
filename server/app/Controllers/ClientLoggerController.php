<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 27.11.2018
 * Time: 23:25
 */

namespace App\Controllers;

use App\Database\DB;

class ClientLoggerController extends RestController
{
    const ERRTYPE = "Client Side Error";

    public function reportErrorLogToClient()
    {
        $errors = DB::table("client_errors")->transferData();
        parent::sendJSON(["errors" => $errors]);
    }

    public function log(){
        $createdAt = parent::receiveJSON()["createdAt"];
        $info = parent::receiveJSON()["info"];
        $error = parent::receiveJSON()["error"];

        $e = "\n". $createdAt." - ".self::ERRTYPE . "\n";


        $e .="\n";
        $e .=$info."\n";

        $e .= "\t" . $error."\n\n";

        
        $e .= "####################################################################################################################";

        DB::table("client_errors")->create([
            "type" => static::ERRTYPE,
            "message" => $info,
            "stack_trace" => $error
        ])->finish();

        error_log($e, 3, __DIR__  .  "/../../store/.log");
        error_log($e, 3, __DIR__  .  "/../../store/client.log");


    }

}