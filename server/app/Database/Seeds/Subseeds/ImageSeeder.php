<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Image;
use App\Database\Connection;

class ImageSeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $image = new Image(new Connection());
        $image->create([ ])->finish();
    }

}