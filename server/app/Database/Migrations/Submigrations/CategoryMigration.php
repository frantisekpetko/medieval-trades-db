<?php

namespace App\Database\Migrations\Submigrations;

use App\Database\BaseMigration;

class CategoryMigration extends BaseMigration {

    protected const TABLE = 'categorys';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'title'  =>  'VARCHAR(150) NOT NULL',
         'product_count'  =>  'INTEGER NOT NULL',
         'parent_id'  =>  'INTEGER NOT NULL',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME'
    ];
    protected static $columns = [
         'id',
         'title',
         'product_count',
         'parent_id',
         'created_at',
         'updated_at',
    ];

    protected static $validation = [
         'title'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'product_count'  =>  [
         'datatype' => 'INTEGER',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'parent_id'  =>  [
         'datatype' => 'INTEGER',
         'nullable' => 'false',
         'unique' => 'false'
         ]
   ];

}