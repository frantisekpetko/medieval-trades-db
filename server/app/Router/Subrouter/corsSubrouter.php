<?php

$router->get(API . 'cors', function () {
    header('Content-Type: application/json, charset=utf-8');

    $isCorsEnable = false;
    $requestMethods = ["GET", "POST", "PUT", "PATCH", "DELETE"];

    if (isset($_SERVER['HTTP_ORIGIN'])) {
        //header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        //header('Access-Control-Allow-Credentials: true');
        //header('Access-Control-Max-Age: 86400');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
            header(
                "Access-Control-Allow-Methods: GET, POST, PUT. PATCH, DELETE, OPTIONS"
            );
        }

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
            header(
                "Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}"
            );
        }

        $isCorsEnable = true;
    }
    header('Content-Type: application/json, charset=utf-8');

    echo json_encode(
        [
            [
                "enable" => $isCorsEnable,
                "id" => 1,
                'requestMethods' => [
                    $requestMethods[0],
                    $requestMethods[1],
                    $requestMethods[2],
                    $requestMethods[3],
                    $requestMethods[4]
                ]
            ]
        ],
        JSON_PRETTY_PRINT
    );
});
