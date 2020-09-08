<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\ServerException;
use App\Database\Connection;

class ServerExceptionSeeder implements IBaseSeeder {

    /**
     * @throws \App\Exceptions\DatabaseException
     */
    public function run()
    {
        $server_exception = new ServerException(new Connection());
        $server_exception->create([ ])->finish();
    }

}