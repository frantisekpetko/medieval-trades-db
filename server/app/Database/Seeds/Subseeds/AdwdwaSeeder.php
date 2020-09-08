<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Adwdwa;
use App\Database\Connection;

class AdwdwaSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $adwdwa = new Adwdwa(new Connection());
        $adwdwa->create([ ])->finish();
    }

}