<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\MedievalTrade;
use App\Database\Connection;

class MedievalTradeSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $medieval_trade = new MedievalTrade(new Connection());
        $medieval_trade->create([ ])->finish();
    }

}