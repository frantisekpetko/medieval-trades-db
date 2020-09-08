<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 12.11.2018
 * Time: 1:28
 */

namespace app\Services;

class CorsService
{
    function __construct()
    {

        function isOriginAllowed($incomingOrigin, $allowOrigin)
        {
            $pattern = '/^http:\/\/([\w_-]+\.)*' . $allowOrigin . '$/';

            $allow = preg_match($pattern, $incomingOrigin);
            if ($allow)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        /*
        foreach($allowOrigin as $origin) {
            if ($incomingOrigin !== null && isOriginAllowed($incomingOrigin, $origin)) {
                exit("CSRF protection in POST request: detected invalid Origin header: " . $incomingOrigin);
            }
        }

        */

        $http_origin = $_SERVER['HTTP_ORIGIN'];

        $allowed_domains = array(
            getenv("APP_DEV_URL"),
            getenv("APP_URL"),
            getenv("DEV_HTTP_ORIGIN"),
            getenv("CLIENT_HTTP_ORIGIN"),
        );

        if (in_array($http_origin, $allowed_domains))
        {
            header("Access-Control-Allow-Origin: $http_origin");
        }

        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day


        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, PUT. PATCH, DELETE, OPTIONS");

            //if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            //header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }
    }
}