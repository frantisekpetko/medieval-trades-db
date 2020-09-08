<?php

namespace App\Database\Migrations\Submigrations;

use App\Database\BaseMigration;

class AwdMigration extends BaseMigration {

    protected const TABLE = 'awds';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'wad'  =>  'VARCHAR(150) NOT NULL',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME'
    ];
    protected static $columns = [
         'id',
         'wad',
         'created_at',
         'updated_at',
    ];

    protected static $validation = [
         'wad'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ]
   ];

}