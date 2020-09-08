<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Mouse;
use App\Database\Connection;

class MouseSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $mouse = new Mouse(new Connection());
        $mouse->create([ ])->finish();
    }

}