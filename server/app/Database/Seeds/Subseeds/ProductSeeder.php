<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Product;
use App\Database\Connection;

class ProductSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $product = new Product(new Connection());
        $product->create([ ])->finish();
    }

}