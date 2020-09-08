<?php

namespace App\Database\Migrations\Submigrations;

use App\Database\BaseMigration;

class TukanMigration extends BaseMigration {

    protected const TABLE = 'tukans';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'name'  =>  'VARCHAR(150) NOT NULL UNIQUE',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME'
    ];
    protected static $columns = [
         'id',
         'name',
         'created_at',
         'updated_at',
    ];


}