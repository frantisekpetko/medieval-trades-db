<?php

namespace App\Database\Migrations\Submigrations;

use App\Database\BaseMigration;

class CustomerMigration extends BaseMigration {

    protected const TABLE = 'customers';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'name'  =>  'VARCHAR(150) NOT NULL',
         'email'  =>  'VARCHAR(150) NOT NULL',
         'password'  =>  'VARCHAR(150) NOT NULL',
         'auth_status'  =>  'VARCHAR(150) NOT NULL',
         'banned_at'  =>  'DATETIME NOT NULL',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME'
    ];
    protected static $columns = [
         'id',
         'name',
         'email',
         'password',
         'auth_status',
         'banned_at',
         'created_at',
         'updated_at',
    ];

    protected static $validation = [
         'name'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'email'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'password'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'auth_status'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'banned_at'  =>  [
         'datatype' => 'DATETIME',
         'nullable' => 'false',
         'unique' => 'false'
         ]
   ];

}