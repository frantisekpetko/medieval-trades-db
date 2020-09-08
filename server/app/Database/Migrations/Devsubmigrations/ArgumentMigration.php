<?php

namespace App\Database\Migrations\Devsubmigrations;

use App\Database\BaseMigration;

class ArgumentMigration extends BaseMigration {

    protected const TABLE = 'arguments';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'type'  =>  'VARCHAR(150)',
         'class'  =>  'VARCHAR(150)',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME',
         'stack_trace_id' => 'INTEGER INTEGER references stack_traces'
    ];
    protected static $columns = [
         'id',
         'type',
         'class',
         'created_at',
         'updated_at',
         'stack_trace_id'
    ];

    protected $foreignKey = 'stack_trace_id';


}