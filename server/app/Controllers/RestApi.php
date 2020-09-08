<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 26.05.2018
 * Time: 17:26
 */

namespace App\Controllers;


trait RestApi
{

    public function getJSON()
    {
        return json_decode(file_get_contents('php://input'));
    }

    public function receiveJSON()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    public function sendJSON($data, $code = 200)
    {

        header('Content-Type: application/json, charset=utf-8');
        // set the actual code
        http_response_code($code);

        // TODO zkontorlovat jestli je toto potřebné pro chod appky
        // set the header to make sure cache is forced
        //header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        // treat this as json
        // TODO END


        $status = array(
            200 => '200 status code | OK',
            201 => '201 status code | Created',
            400 => '400 status code | Bad Request',
            422 => '422 status code | Unprocessable Entity',
            500 => '500 status code | Internal Server Error'
        );

        // TODO zkontorlovat jestli je toto potřebné pro chod appky
        // ok, validation error, or failure
        //header('Status: ' . $status[$code]);
        // return the encoded json
        // TODO END
        //header(sprintf('Status:  %s', $status[$code]) );

        //header('Content-Type: application/json, charset=utf-8');
        echo json_encode(
            $data,
            /*is_array($status[$code]) ? $status[$code] : null,*/
            JSON_PRETTY_PRINT
        );

    }
}

