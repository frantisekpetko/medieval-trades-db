<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Sssss;
use App\Database\Connection;

class SssssSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $sssss = new Sssss(new Connection());
        $sssss->create([ ])->finish();
    }

}