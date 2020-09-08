<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Daw;
use App\Database\Connection;

class DawSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $daw = new Daw(new Connection());
        $daw->create([ ])->finish();
    }

}