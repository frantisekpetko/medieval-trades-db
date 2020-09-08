<?php

namespace App\Database\Migrations\Submigrations;

use App\Database\BaseMigration;

class OrderMigration extends BaseMigration {

    protected const TABLE = 'orders';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'mail_type_order'  =>  'VARCHAR(150) NOT NULL',
         'transport_type'  =>  'VARCHAR(150) NOT NULL',
         'payment_type'  =>  'VARCHAR(150) NOT NULL',
         'note'  =>  'VARCHAR(150) NOT NULL',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME'
    ];
    protected static $columns = [
         'id',
         'mail_type_order',
         'transport_type',
         'payment_type',
         'note',
         'created_at',
         'updated_at',
    ];

    protected static $validation = [
         'mail_type_order'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'transport_type'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'payment_type'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'note'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ]
   ];

}