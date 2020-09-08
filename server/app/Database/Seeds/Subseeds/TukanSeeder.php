<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Tukan;
use App\Database\Connection;

class TukanSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $tukan = new Tukan(new Connection());
        $tukan->create([ ])->finish();
    }

}