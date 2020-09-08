<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Lord;
use App\Database\Connection;

class LordSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $lord = new Lord(new Connection());
        $lord->create([ ])->finish();
    }

}