<?php


namespace App\Controllers\DevControllers;

use App\Controllers\RestApi;
use App\Controllers\RestController;
use App\Database\DB;
use App\Database\Migrations\MainMigration;
use App\Database\Seeds\MainSeeder;

class DatabaseAssistantController extends RestController
{
    use RestApi;


    public function cleanUpDatabase()
    {

        $schema = DB::schema();
        $db = $schema ->getPDO();
        $removedTables = [];

        //$stm = $db->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
        //$stm = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND NOT name LIKE 'sqlite_%';");

        $db->exec("BEGIN");
        $stm = $db->query("SELECT * from sqlite_master;");
        //$result = $stm->fetch(\PDO::FETCH_ASSOC);
        //$tables[] = $result;
        $result = $stm->fetchAll(\PDO::FETCH_ASSOC);
        $stm->closeCursor();

        foreach($result as $tableName)
        {

            $unlockTbl = sprintf('UNLOCK TABLE %s;', $tableName["tbl_name"]);
            $db->exec($unlockTbl);
            $sqlDeleteTbl = sprintf('DROP TABLE %s;', $tableName["tbl_name"]);

            $delete = null;
            $error = null;
            if ($tableName["tbl_name"] !== "sqlite_sequence" ){
                $delete = $db->exec($sqlDeleteTbl);
                $error  = $db->errorInfo();
            }
            $tableName["tbl_name"] !== "sqlite_sequence" ? array_push($removedTables,   $tableName["tbl_name"], $error) :null;
        }

        $db->exec("COMMIT");

        parent::sendJSON([["removedTables" => $removedTables]]);
    }


    public function runAllMigrations()
    {
        $migration = new MainMigration();
        $migration->run();
    }


    public function runAllSeeds()
    {
        $seeder = new MainSeeder();
        $seeder->run();
    }
    
}