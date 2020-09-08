<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\ClientError;
use App\Database\Connection;

class ClientErrorSeeder implements IBaseSeeder {

    /**
     * @throws \App\Exceptions\DatabaseException
     */
    public function run()
    {
        $client_error = new ClientError(new Connection());
        $client_error->create([ ]);
    }

}