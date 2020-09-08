<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Owner;
use App\Database\Connection;

class OwnerSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $owner = new Owner(new Connection());
        $owner->create([ ])->finish();
    }

}