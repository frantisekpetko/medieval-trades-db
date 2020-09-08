<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Customers;
use App\Database\Connection;

class CustomersSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $customers = new Customers(new Connection());
        $customers->create([ ])->finish();
    }

}