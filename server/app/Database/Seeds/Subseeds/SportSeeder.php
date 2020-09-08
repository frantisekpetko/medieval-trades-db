<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Sport;
use App\Database\Connection;

class SportSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $sport = new Sport(new Connection());
        $sport->create([ ])->finish();
    }

}