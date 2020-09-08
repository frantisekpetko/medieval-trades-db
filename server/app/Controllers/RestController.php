<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 17.11.2018
 * Time: 14:11
 */

namespace App\Controllers;


class RestController
{
    use RestApi;

    protected $statusCodes = [
        'done' => 200,
        'created' => 201,
        'removed' => 204,
        'not_valid' => 400,
        'not_found' => 404,
        'conflict' => 409,
        'permissions' => 401,
        'unprocessable_entity' => 422,
        'internal_server_error' => 500
    ];


}