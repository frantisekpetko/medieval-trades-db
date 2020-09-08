<?php

namespace App\Database\Migrations\Devsubmigrations;

use App\Database\BaseMigration;

class ClientErrorMigration extends BaseMigration {

    protected const TABLE = 'client_errors';
    protected $dataSchema = [
         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',
         'type'  =>  'VARCHAR(150) NOT NULL',
         'message'  =>  'VARCHAR(150) NOT NULL',
         'stack_trace'  =>  'TEXT NOT NULL',
         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
         'updated_at' => 'DATETIME',

    ];
    protected static $columns = [
         'id',
         'type',
         'message',
         'stack_trace',
         'created_at',
         'updated_at',
    ];


}