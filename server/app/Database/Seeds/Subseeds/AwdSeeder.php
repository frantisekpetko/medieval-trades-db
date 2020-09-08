<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Awd;
use App\Database\Connection;

class AwdSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $awd = new Awd(new Connection());
        $awd->create([ ])->finish();
    }

}