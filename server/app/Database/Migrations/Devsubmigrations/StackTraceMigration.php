<?php

namespace App\Database\Migrations\Devsubmigrations;

use App\Database\BaseMigration;

class StackTraceMigration extends BaseMigration {

    protected const TABLE = 'stack_traces';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'namespace'  =>  'VARCHAR(150)',
         'short_class'  =>  'VARCHAR(150)',
         'class'  =>  'VARCHAR(150)',
         'type'  =>  'VARCHAR(150)',
         'function'  =>  'VARCHAR(150)',
         'file'  =>  'VARCHAR(150)',
         'line'  =>  'INTEGER',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME',
         'server_exception_id' => 'INTEGER references server_exceptions'
    ];
    protected static $columns = [
         'id',
         'namespace',
         'short_class',
         'class',
         'type',
         'function',
         'file',
         'line',
         'created_at',
         'updated_at',
         'server_exception_id'
    ];
    protected $foreignKey = 'server_exception_id';

}