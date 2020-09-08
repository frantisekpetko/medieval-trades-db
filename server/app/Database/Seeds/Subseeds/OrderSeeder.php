<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Order;
use App\Database\Connection;

class OrderSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $order = new Order(new Connection());
        $order->create([ ])->finish();
    }

}