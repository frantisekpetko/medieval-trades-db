<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 27.10.2018
 * Time: 10:14
 */
namespace App\Controllers;


interface IController {

    public function index();

    public function store();

    public function single($id);

    public function update($id);

    public function erase($id);

}