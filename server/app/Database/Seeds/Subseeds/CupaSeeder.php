<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Cupa;
use App\Database\Connection;

class CupaSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $cupa = new Cupa(new Connection());
        $cupa->create([ ])->finish();
    }

}