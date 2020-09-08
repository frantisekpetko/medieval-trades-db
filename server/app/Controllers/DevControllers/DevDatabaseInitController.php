<?php
namespace App\Controllers\DevControllers;

use App\Database\DevConnection;
use App\Database\DevDB;
use App\Controllers\ExceptionControllers\ExceptionController;
use App\Controllers\RestApi;
use App\Database\Migrations\Devsubmigrations\ClientErrorMigration;
use App\Database\Migrations\Devsubmigrations\StackTraceMigration;
use App\Database\Migrations\Devsubmigrations\ServerExceptionMigration;
use App\Database\Migrations\Devsubmigrations\ArgumentMigration;
use App\Database\Migrations\Devsubmigrations\UnsafeExceptionMigration;

class DevDatabaseInitController
{

    use RestApi;

    public function initDatabase()
    {
            
        $eControl = new ExceptionController(
            new ClientErrorMigration(),
            new StackTraceMigration(),
            new ServerExceptionMigration(),
            new UnsafeExceptionMigration(),
            new ArgumentMigration(/*DevConnection::whoAmI()*/)
        );

        $results = DevDB::table("sqlite_master")->all()->transferData();

        $final_tables = [
            [
                "name" => "client_errors",
            ],
            [
                "name" => "server_exceptions",
            ],
            [
                "name" => "stack_traces",
            ],
            [
                "name" => "unsafe_exceptions",
            ],
            [
                "name" => "arguments",
            ]
        ];
        $tables =[];
        $status = [];
        foreach ($results as $table)
        {

            if(@findKey($final_tables, $table["tbl_name"]))
            {
                $status = $eControl->createTables()->makeDatabaseRelations();

                if (@$table["tbl_name"] !== "sqlite_sequence")
                {
                    array_push($tables, $table);
                }
            }
            
        }

        parent::sendJSON(["status" => $status]);

    }

    

}

