<?php

namespace App\Database\Migrations\Submigrations;

use App\Database\BaseMigration;

class ImageMigration extends BaseMigration {

    protected const TABLE = 'images';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'img_name'  =>  'VARCHAR(150) NOT NULL',
         'img_path'  =>  'VARCHAR(150) NOT NULL',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME'
    ];
    protected static $columns = [
         'id',
         'img_name',
         'img_path',
         'created_at',
         'updated_at',
    ];

    protected static $validation = [
         'img_name'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'img_path'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ]
   ];

}