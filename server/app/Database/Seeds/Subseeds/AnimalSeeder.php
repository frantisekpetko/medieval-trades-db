<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Animal;
use App\Database\Connection;

class AnimalSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $animal = new Animal(new Connection());
        $animal->create([ ])->finish();
    }

}