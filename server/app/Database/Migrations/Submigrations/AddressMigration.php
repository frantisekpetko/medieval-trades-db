<?php

namespace App\Database\Migrations\Submigrations;

use App\Database\BaseMigration;

class AddressMigration extends BaseMigration {

    protected const TABLE = 'addresss';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'name'  =>  'VARCHAR(150) NOT NULL',
         'street'  =>  'VARCHAR(150) NOT NULL',
         'city'  =>  'VARCHAR(150) NOT NULL',
         'postal_code'  =>  'VARCHAR(150) NOT NULL',
         'state'  =>  'VARCHAR(150) NOT NULL',
         'region'  =>  'VARCHAR(150) NOT NULL',
         'telephone'  =>  'VARCHAR(150) NOT NULL',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME'
    ];
    protected static $columns = [
         'id',
         'name',
         'street',
         'city',
         'postal_code',
         'state',
         'region',
         'telephone',
         'created_at',
         'updated_at',
    ];

    protected static $validation = [
         'name'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'street'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'city'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'postal_code'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'state'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'region'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'telephone'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ]
   ];

}