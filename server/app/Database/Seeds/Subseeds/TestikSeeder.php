<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Testik;
use App\Database\Connection;

class TestikSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $testik = new Testik(new Connection());
        $testik->create([ ])->finish();
    }

}