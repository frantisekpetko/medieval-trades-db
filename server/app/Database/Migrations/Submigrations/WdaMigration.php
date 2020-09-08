<?php

namespace App\Database\Migrations\Submigrations;

use App\Database\BaseMigration;

class WdaMigration extends BaseMigration {

    protected const TABLE = 'wdas';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'adwdwa'  =>  'VARCHAR(150) NOT NULL UNIQUE',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME'
    ];
    protected static $columns = [
         'id',
         'adwdwa',
         'created_at',
         'updated_at',
    ];


}