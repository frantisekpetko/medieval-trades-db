<?php

namespace App\Controllers;

use App\Controllers\IController;
use App\Controllers\RestController;

class CustomersController extends RestController implements IController
{
    private $customers;

    public function __construct(){}

    public function index()
    {
       parent::sendJSON([["collection" => []]]);
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function single($id)
    {
        parent::sendJSON([["individual" => ["id" => $id]]]);
    }

    public function update($id)
    {

    }

    public function erase($id)
    {

    }
}
