<?php

namespace App\Controllers\Eshop\Resource;

use App\Controllers\IController;
use App\Controllers\RestController;
use App\Entities\Category;

class CategoryController extends RestController implements IController
{

    public function index()
    {
        parent::sendJSON([["collection" => []]]);
    }

    public function create()
    {

    }

    public function store()
    {
        $category = new Category();
        $category->title =  $this->getJSON()->title;
        $category->product_count =  $this->getJSON()->product_count;
        $category->parent_id =  $this->getJSON()->parent_id;
        $category->save();

        parent::sendJSON(["individual" => [
            "category" => $category
        ]], 201);
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
