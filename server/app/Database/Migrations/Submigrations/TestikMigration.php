<?php

namespace App\Database\Migrations\Submigrations;

use App\Database\BaseMigration;

class TestikMigration extends BaseMigration {

    protected const TABLE = 'testiks';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'name'  =>  'VARCHAR(150) NOT NULL',
         'count'  =>  'INTEGER NOT NULL',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME'
    ];
    protected static $columns = [
         'id',
         'name',
         'count',
         'created_at',
         'updated_at',
    ];

    protected static $validation = [
         'name'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'count'  =>  [
         'datatype' => 'INTEGER',
         'nullable' => 'false',
         'unique' => 'false'
         ]
   ];

}