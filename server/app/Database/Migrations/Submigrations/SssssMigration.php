<?php

namespace App\Database\Migrations\Submigrations;

use App\Database\BaseMigration;

class SssssMigration extends BaseMigration {

    protected const TABLE = 'ssssss';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'sssss'  =>  'VARCHAR(150) NOT NULL UNIQUE',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME'
    ];
    protected static $columns = [
         'id',
         'sssss',
         'created_at',
         'updated_at',
    ];


}