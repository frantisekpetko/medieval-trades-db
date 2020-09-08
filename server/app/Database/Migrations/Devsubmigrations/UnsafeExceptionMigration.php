<?php

namespace App\Database\Migrations\Devsubmigrations;

use App\Database\BaseMigration;

class UnsafeExceptionMigration extends BaseMigration {

    protected const TABLE = 'unsafe_exceptions';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'class'  =>  'VARCHAR(150)',
         'message'  =>  'TEXT',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME',
         'server_exception_id' => 'INTEGER references server_exceptions'
    ];
    protected static $columns = [
         'id',
         'class',
         'message',
         'created_at',
         'updated_at',
         'server_exception_id'
    ];
    protected $foreignKey = 'server_exception_id';

}