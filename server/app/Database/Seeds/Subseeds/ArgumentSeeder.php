<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Argument;
use App\Database\Connection;

class ArgumentSeeder implements IBaseSeeder {

    /**
     * @throws \App\Exceptions\DatabaseException
     */
    public function run()
    {
        $argument = new Argument(new Connection());
        $argument->create([ ]);
    }

}