<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Admin;
use App\Database\Connection;

class AdminSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $admin = new Admin(new Connection());
        $admin->create([ ])->finish();
    }

}