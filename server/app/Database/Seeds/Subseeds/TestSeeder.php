<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Test;
use App\Database\Connection;

class TestSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $test = new Test(new Connection());
        $test->create([ ])->finish();
    }

}