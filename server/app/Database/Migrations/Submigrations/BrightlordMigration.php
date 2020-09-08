<?php

namespace App\Database\Migrations\Submigrations;

use App\Database\BaseMigration;

class BrightlordMigration extends BaseMigration {

    protected const TABLE = 'brightlords';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'name'  =>  'VARCHAR(150) NOT NULL',
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