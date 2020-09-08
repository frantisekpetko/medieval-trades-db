<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Brightlord;
use App\Database\Connection;

class BrightlordSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $brightlord = new Brightlord(new Connection());
        $brightlord->create([ ])->finish();
    }

}