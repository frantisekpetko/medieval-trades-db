<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Bacal;
use App\Database\Connection;

class BacalSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $bacal = new Bacal(new Connection());
        $bacal->create([ ])->finish();
    }

}