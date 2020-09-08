<?php

namespace App\Controllers\ExceptionControllers;

use App\Database\DevDB;
use App\Database\Migrations\Devsubmigrations\ClientErrorMigration;
use App\Database\Migrations\Devsubmigrations\StackTraceMigration;
use App\Database\Migrations\Devsubmigrations\ServerExceptionMigration;
use App\Database\Migrations\Devsubmigrations\ArgumentMigration;
use App\Database\Migrations\Devsubmigrations\UnsafeExceptionMigration;

class ExceptionController
{
    private $migration_1;
    private $migration_2;
    private $migration_3;
    private $migration_4;
    private $migration_5;

    public function __construct(ClientErrorMigration $error, StackTraceMigration $stackTrace,
                                ServerExceptionMigration $exception, UnsafeExceptionMigration
                                $unsafeException, ArgumentMigration $argument)
    {
        $this->migration_1 = $error;
        $this->migration_2 = $stackTrace;
        $this->migration_3 = $exception;
        $this->migration_4 = $unsafeException;
        $this->migration_5 = $argument;
    }



    public function createTables()
    {
        $this->migration_1->up();
        $this->migration_2->up();
        $this->migration_3->up();
        $this->migration_4->up();
        $this->migration_5->up();
 
        return $this;
    }

    public function makeDatabaseRelations()
    {

        $rel_1 = DevDB::schema()->addRelationship(
            "ServerException",
            "StackTrace",
            "server_exceptions",
            "stack_traces",
            "oneToMany",
            true
        );


        $rel_2 = DevDB::schema()->addRelationship(
            "StackTrace",
            "Argument",
            "stack_traces",
            "arguments",
            "oneToMany",
            true
        );

        $rel_3 = DevDB::schema()->addRelationship(
            "ServerException",
            "UnsafeException",
            "server_exceptions",
            "unsafe_exceptions",
            "oneToOne",
            true
        );


        return [
            "firstRel" => $rel_1,
            "secondRel" => $rel_2,
            "thirdRel" => $rel_3
        ];
    }
}
