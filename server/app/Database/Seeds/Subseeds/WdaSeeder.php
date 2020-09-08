<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Wda;
use App\Database\Connection;

class WdaSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $wda = new Wda(new Connection());
        $wda->create([ ])->finish();
    }

}