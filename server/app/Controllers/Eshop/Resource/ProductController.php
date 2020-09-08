<?php

namespace App\Controllers\Eshop\Resource;

use App\Controllers\IController;
use App\Controllers\RestController;
use App\Entities\Product;
use App\Entities\Image;
use App\Entities\Category;
use Illuminate\Contracts\Pagination\Paginator;

class ProductController extends RestController implements IController
{

    public function index()
    {
        $products = Product::with("image")->with("category")->get();
        return parent::sendJSON([["collection" => [$products]]]);
    }

    public function pagination($limit)
    {

        parent::sendJSON([["collection" => [ Product::with("image")->with("category")->inRandomOrder()->limit($limit)->get()]]]);
        //$products = Product::where("id", with("image")->with("category")->limit($limit)->get();
        //parent::sendJSON([["collection" => [$products]]]);
    }

    public function store()
    {
        $category = Category::where('title', parent::getJSON()->category)->first();

        $product = new Product();
        $product->name =   $this->getJSON()->name;
        $product->title =   $this->getJSON()->title;
        $product->description = $this->getJSON()->description;
        $product->stock_quantity = $this->getJSON()->stock_quantity;
        $product->price =   $this->getJSON()->price;
        $product->price_vat = $this->getJSON()->price_vat;
        $product->vat = $this->getJSON()->vat;
        $product->discount =   $this->getJSON()->discount;
        $product->admin_id = $this->getJSON()->admin_id;
        $product->category_id = $category->id;
        $product->save();

        $image = new Image();
        $image->img_name =  $this->getJSON()->img_name;
        $image->img_path =  $this->getJSON()->img_path;
        $image->product_id =  $product->id;
        $image->save();

        parent::sendJSON(["individual" => [
            "product" =>$product,
            "image" => $image
        ]], 201);
    }

    public function single($id)
    {
        $product = Product::where('id', $id)->with("image")->with("category")->get();
        parent::sendJSON([["individual" => [$product]]]);
    }

    public function update($id)
    {

    }

    public function erase($id)
    {

    }
}
