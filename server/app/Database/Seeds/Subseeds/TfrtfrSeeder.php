<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Tfrtfr;
use App\Database\Connection;

class TfrtfrSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $tfrtfr = new Tfrtfr(new Connection());
        $tfrtfr->create([ ])->finish();
    }

}