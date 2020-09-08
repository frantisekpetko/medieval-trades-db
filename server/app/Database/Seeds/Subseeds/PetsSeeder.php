<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Pets;
use App\Database\Connection;

class PetsSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $pets = new Pets(new Connection());
        $pets->create([ ])->finish();
    }

}