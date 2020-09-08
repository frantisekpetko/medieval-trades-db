<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Firelord;
use App\Database\Connection;

class FirelordSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $firelord = new Firelord(new Connection());
        $firelord->create([ ])->finish();
    }

}