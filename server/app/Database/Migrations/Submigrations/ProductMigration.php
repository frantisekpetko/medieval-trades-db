<?php

namespace App\Database\Migrations\Submigrations;

use App\Database\BaseMigration;

class ProductMigration extends BaseMigration {

    protected const TABLE = 'products';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'name'  =>  'VARCHAR(150) NOT NULL',
         'title'  =>  'VARCHAR(150) NOT NULL',
         'description'  =>  'VARCHAR(150) NOT NULL',
         'stock_quantity'  =>  'INTEGER NOT NULL',
         'price'  =>  'INTEGER NOT NULL',
         'price_vat'  =>  'INTEGER NOT NULL',
         'vat'  =>  'INTEGER NOT NULL',
         'discount'  =>  'INTEGER NOT NULL',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME'
    ];
    protected static $columns = [
         'id',
         'name',
         'title',
         'description',
         'stock_quantity',
         'price',
         'price_vat',
         'vat',
         'discount',
         'created_at',
         'updated_at',
    ];

    protected static $validation = [
         'name'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'title'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'description'  =>  [
         'datatype' => 'STRING',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'stock_quantity'  =>  [
         'datatype' => 'INTEGER',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'price'  =>  [
         'datatype' => 'INTEGER',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'price_vat'  =>  [
         'datatype' => 'INTEGER',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'vat'  =>  [
         'datatype' => 'INTEGER',
         'nullable' => 'false',
         'unique' => 'false'
         ],
         'discount'  =>  [
         'datatype' => 'INTEGER',
         'nullable' => 'false',
         'unique' => 'false'
         ]
   ];

}