<?php

namespace App\Database\Migrations\Submigrations;

use App\Database\BaseMigration;

class CustomersMigration extends BaseMigration {

    protected const TABLE = 'customerss';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'name'  =>  'VARCHAR(150) NOT NULL',
         'work'  =>  'VARCHAR(150) NOT NULL',
         'age'  =>  'INTEGER NOT NULL',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME'
    ];
    protected static $columns = [
         'id',
         'name',
         'work',
         'age',
         'created_at',
         'updated_at',
    ];

    protected static $validation = [
         'name'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'work'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'age'  =>  [
         'datatype' => 'INTEGER',
         'nullable' => 'false',
         'unique' => 'false'
         ]
   ];

}