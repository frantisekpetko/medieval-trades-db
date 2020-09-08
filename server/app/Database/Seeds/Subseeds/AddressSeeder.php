<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Address;
use App\Database\Connection;

class AddressSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $address = new Address(new Connection());
        $address->create([ ])->finish();
    }

}