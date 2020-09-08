<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\StackTrace;
use App\Database\Connection;

class StackTraceSeeder implements IBaseSeeder {

    /**
     * @throws \App\Exceptions\DatabaseException
     */
    public function run()
    {
        $stack_trace = new StackTrace(new Connection());
        $stack_trace->create([ ]);
    }

}