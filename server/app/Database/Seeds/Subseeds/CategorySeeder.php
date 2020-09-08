<?php

namespace App\Database\Seeds\Subseeds;

use App\Database\IBaseSeeder;
use App\Models\Category;
use App\Database\Connection;

class CategorySeeder implements IBaseSeeder {

    /**
     * @throws \App\Errors\DatabaseException
     */
    public function run()
    {
        $category = new Category(new Connection());
        $category->create([ ])->finish();
    }

}