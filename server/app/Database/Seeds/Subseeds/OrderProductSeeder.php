<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\OrderProduct;
use App\Database\Connection;

class OrderProductSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $order_product = new OrderProduct(new Connection());
        $order_product->create([ ])->finish();
    }

}