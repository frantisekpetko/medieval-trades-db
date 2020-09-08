<?php

namespace App\Database\Migrations\Devsubmigrations;

use App\Database\BaseMigration;

class ServerExceptionMigration extends BaseMigration {

    protected const TABLE = 'server_exceptions';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'type'  =>  'VARCHAR(150) NOT NULL',
         'message'  =>  'VARCHAR(150)',
         'class'  =>  'VARCHAR(150)',
         'current'  =>  'VARCHAR(150)',
         'total'  =>  'VARCHAR(150)',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME',
         'unsafe_exception_id' => 'INTEGER references unsafe_exceptions'
    ];
    protected static $columns = [
         'id',
         'type',
         'message',
         'class',
         'current',
         'total',
         'created_at',
         'updated_at',
         'unsafe_exception_id'
    ];
    protected $foreignKey = 'unsafe_exception_id';

}