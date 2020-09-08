<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Dawd;
use App\Database\Connection;

class DawdSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $dawd = new Dawd(new Connection());
        $dawd->create([ ])->finish();
    }

}