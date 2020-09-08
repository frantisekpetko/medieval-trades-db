<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Customer;
use App\Database\Connection;

class CustomerSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $customer = new Customer(new Connection());
        $customer->create([ ])->finish();
    }

}