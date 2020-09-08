<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Pet;
use App\Database\Connection;

class PetSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $pet = new Pet(new Connection());
        $pet->create([ ])->finish();
    }

}