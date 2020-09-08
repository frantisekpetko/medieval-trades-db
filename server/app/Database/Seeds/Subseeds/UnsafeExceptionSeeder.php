<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\UnsafeException;
use App\Database\Connection;

class UnsafeExceptionSeeder implements IBaseSeeder {

    /**
     * @throws \App\Exceptions\DatabaseException
     */
    public function run()
    {
        $unsafe_exception = new UnsafeException(new Connection());
        $unsafe_exception->create([ ]);
    }

}