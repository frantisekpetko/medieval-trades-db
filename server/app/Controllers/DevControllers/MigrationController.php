<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 08.01.2019
 * Time: 19:39
 */

namespace App\Controllers\DevControllers;

use App\Controllers\RestApi;
use App\Controllers\RestController;
use App\Database\Migrations\Submigrations\PetMigration;

class MigrationController extends RestController
{

    use RestApi;
    private $preview;
    private $migrationStr;
    private $seederStr;
    private $modelPreview;
    private $entityName;

    const MODEL_TEMPLATE_STORE_PATH = __DIR__ . '/../../Console/ComponentFactory/ClassTemplateStore/DummyModel.stub';

    public function sendMigrationClassPreview()
    {
        parent::sendJSON([
            "preview" => $this->migrationStr,
            "seeder" => $this->seederStr,
            "modelPreview" => $this->modelPreview
        ]);
    }

    public function finishGenerateMigrationClass()
    {
        $data = parent::receiveJSON();
        $model = $data["name"];
        rename(__DIR__ . '/../../Database/Migrations/Submigrations/DummyMigration.stub',  __DIR__ . '/../../Database/Migrations/Submigrations/' . \ucfirst($model). 'Migration.php');
    }

    public function getModelTemplatePart($entityName)
    {
        $model = static::MODEL_TEMPLATE_STORE_PATH;
        $lines = file($model);
        foreach ($lines as $text) {
            if (strpos( $text, "class") === 0) {
                $text = str_replace('DummyModel', $entityName, $text);
                $this->modelPreview .= (string)$text;
                break;
            }
            $this->modelPreview .= (string)$text;
        }
    }
    
    public function generateMigrationClass()
    {

        $data = parent::receiveJSON();
        $migration = $data["name"];
        $count = $data["count"];
        $column = $data["columns"];

        if(copy( __DIR__ . '/../../Console/ComponentFactory/ClassTemplateStore/DummyMigration.stub', __DIR__ . '/../../Database/Migrations/Submigrations/DummyMigration.stub')){
            //error_log(" \nafter condition\n", 3, "./store/server.log");
            $str = file_get_contents(__DIR__ . '/../../Database/Migrations/Submigrations/DummyMigration.stub');

            //replace something in the file string - this is a VERY simple example
            $str = str_replace("DummyMigration", \ucfirst($migration) . "Migration", $str);

            //strcspn('aAple', 'ABCDEFGHJIJKLMNOPQRSTUVWXYZ');
            $str = str_replace("dummymodel", sprintf("%ss", $this->formatModelName($migration))  , $str);
            //require_once __DIR__ . "/../../Database/Migrations/" . $input->getArgument('model') . "Migration.php";
            //error_log(" \nafter created dummy files\n", 3, "./store/server.log");
            /*
            $model =  $input->getArgument('model');
            $migration = 'App\\Database\\Migrations\\' . $model . 'Migration';
            $instance =  new $migration();
            */

            $dataSchemaStr = 'protected $dataSchema = [' . "\n";
            $numericOrder = 0;
            //error_log(" \nbefore loop\n  ", 3, "./store/server.log");
            for($i = 0; $i < $count + 1 ; $i++){
                if($numericOrder === 0) {
                    $dataSchemaStr.= "         'id' => 'INTEGER PRIMARY KEY AUTOINCREMENT',\n";

                }
                else {
                    $notNull = $column[$i -1]["notNull"];
                    $columnName = $column[$i -1]["nameOfColumn"];
                    $datatype = $column[$i -1]["datatype"];
                    $unique = $column[$i -1]["unique"];
                    //error_log( "\nItem :  " .   $datatype, 3, "./store/server.log");

                    $text_datatype = "";

                    switch ($datatype) {
                        case "varchar":
                            $text_datatype = "VARCHAR(150)";
                            break;
                        case "text":
                            $text_datatype = "TEXT";
                            break;
                        case "integer":
                            $text_datatype = "INTEGER";
                            break;
                        case "blob":
                            $text_datatype = "BLOB";
                            break;
                        case "real":
                            $text_datatype = "REAL";
                            break;
                        case "boolean":
                            $text_datatype = "BOOLEAN";
                            break;
                        case "date":
                            $text_datatype = "DATE";
                            break;
                        case "datetime":
                            $text_datatype = "DATETIME";
                            break;
                    }

                    $dataSchemaStr.= "         '". $columnName ."'  =>  '". $text_datatype. ($notNull ? " NOT NULL" : null).($unique ? " UNIQUE" : null)."',\n";
                }

                $numericOrder++;
            }

            $dataSchemaStr.= "         'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',\n";
            $dataSchemaStr.= "         'updated_at' => 'DATETIME'\n    ];";


            $validationStr = 'protected static $validation = [' . "\n";
            $numericOrder = 0;
            //error_log(" \nbefore loop\n  ", 3, "./store/server.log");
            for($i = 0; $i < $count + 1 ; $i++){
                if($numericOrder === 0) {

                }
                else {
                    $notNull = $column[$i -1]["notNull"];
                    $columnName = $column[$i -1]["nameOfColumn"];
                    $datatype = $column[$i -1]["datatype"];
                    $unique = $column[$i -1]["unique"];
                    //error_log( "\nItem :  " .   $datatype, 3, "./store/server.log");

                    $text_datatype = "";

                    switch ($datatype) {
                        case "varchar":
                            $text_datatype = "STRING";
                            break;
                        case "text":
                            $text_datatype = "STRING";
                            break;
                        case "integer":
                            $text_datatype = "INTEGER";
                            break;
                        case "blob":
                            $text_datatype = "BINAR";
                            break;
                        case "real":
                            $text_datatype = "DOUBLE";
                            break;
                        case "boolean":
                            $text_datatype = "BOOLEAN";
                            break;
                        case "date":
                            $text_datatype = "DATE";
                            break;
                        case "datetime":
                            $text_datatype = "DATETIME";
                            break;
                    }

                    if ($count === 1) {
                        $validationStr.= "         '". $columnName ."'  =>  [\n         'datatype' => '". $text_datatype."',\n". "         'nullable' => '".($notNull === 1 ? "true" : "false")."',\n         'unique' => '".($unique === 1 ? "true" : "false")."'\n         ]\n";

                    }
                    else {
                        if ($count === $numericOrder) {
                            $validationStr.= "         '". $columnName ."'  =>  [\n         'datatype' => '". $text_datatype."',\n". "         'nullable' => '".($notNull === 1 ? "true" : "false")."',\n         'unique' => '".($unique === 1 ? "true" : "false")."'\n         ]\n";
                        }
                        else {
                            $validationStr.= "         '". $columnName ."'  =>  [\n         'datatype' => '". $text_datatype."',\n". "         'nullable' => '".($notNull === 1 ? "true" : "false")."',\n         'unique' => '".($unique === 1 ? "true" : "false")."'\n         ],\n";
                        }
                    }


                }

                $numericOrder++;
            }
            $validationStr.= "   ];";
            //error_log(" \nmidd\n  ", 3, "./store/server.log");


            $search_1 = 'protected $dataSchema = [];';
            $search_2 = 'protected static $columns = [];';
            $search_3 = 'protected static $validation = [];';


            $columnsStr = 'protected static $columns = [' . "\n";
            $columnsStr .= sprintf("         '%s',\n", "id");
            for ($q = 0; $q < $count; $q++)
            {
                    $columnName = $column[$q]["nameOfColumn"];
                    $columnsStr .= sprintf("         '%s',\n", $columnName);
            }
            $columnsStr .= sprintf("         '%s',\n", "created_at");
            $columnsStr .= sprintf("         '%s',\n", "updated_at");
            $columnsStr .= "    ];\n";


            $str = str_replace($search_1,  $search_1 . $dataSchemaStr,   $str);
            $str = str_replace($search_1,  '',   $str);

            $str = str_replace($search_2,  $columnsStr,   $str);
            $str = str_replace($search_2,  '',  $str);

            $str = str_replace($search_3,  $validationStr,   $str);
            $str = str_replace($search_3,  '',  $str);

            $this->migrationStr = $str;
            $this->getModelTemplatePart(ucfirst($migration));
            $this->generateSeederClass(ucfirst($migration));
            $this->sendMigrationClassPreview();

            file_put_contents(__DIR__ . '/../../Database/Migrations/Submigrations/DummyMigration.stub', $str);
            //error_log( "\n" .   $this->preview , 3, "./store/server.log");
        }
    }




    public function generateSeederClass($entity)
    {

        $data = parent::receiveJSON();
        //$migration = $data["name"];
        //$count = $data["count"];
        $column = $data["columns"];

        if(copy( __DIR__ . '/../../Console/ComponentFactory/ClassTemplateStore/DummySeeder.stub',
            __DIR__ . '/../../Database/Seeds/Subseeds/DummySeeder.stub')){

            $str = file_get_contents(__DIR__ . '/../../Database/Seeds/Subseeds/DummySeeder.stub');
            $str = str_replace("use App\Models\DummyModel", "use App\Models\\" . $entity, $str);

            //replace something in the file string - this is a VERY simple example
            $str = str_replace("DummySeeder", $entity. "Seeder", $str);


            $str = str_replace('$dummy', '$' . $this->formatModelName($entity) , $str);
            //$str = str_replace('$dummy', '$' . $this->formatModelName($input->getArgument('seed')) , $str);
            $str = str_replace('DummyModel',  $entity , $str);
            //require_once __DIR__ . "/../../Database/Migrations/" . $input->getArgument('model') . "Migration.php";


            $columnsStr = '$dummy->create([' . "\n";
            $numericOrder = 0;
            $count = count($column);
            foreach($column as $key => $value){
                if($numericOrder !== $count - 3) {
                    if ($key !== "id" && $key !== "created_at" && $key !== "updated_at")
                    {
                        $columnsStr.= "         ". "'"."$key" ."'" . "  => '',\n";
                    }



                }
                else {
                    if ($key !== "id" && $key !== "created_at" && $key !== "updated_at")
                    {
                        $columnsStr.= "         ". "'". $key ."'" . "  => ''\n        ])->finish();";
                    }
                }
                $numericOrder++;
            }

            $search = '$dummy->create([ ])->finish();';

            $str = str_replace($search,  $search . $columnsStr,   $str);
            $str = str_replace($search,  '',   $str);
            //write the entire string
            $str = str_replace('$dummy', '$' . $this->formatModelName($entity), $str);
            file_put_contents(__DIR__ . '/../../Database/Seeds/Subseeds/DummySeeder.stub', $str);
            $this->seederStr = $str;

            rename(__DIR__ . '/../../Database/Seeds/Subseeds/DummySeeder.stub',  __DIR__ . '/../../Database/Seeds/Subseeds/'. $entity. 'Seeder.php');


        }
    }

    public function cancelOperation()
    {
        unlink(__DIR__ . "/../../Database/Migrations/Submigrations/DummyMigration.stub");
    }

    private function formatModelName($str):string{

        $count = strlen($str);

        $i = 0;
        $ii = 0;
        $strarr  = str_split($str);
        while($i < $count)
        {
            $char = $strarr{$i};
            if(preg_match("[A-Z]", $char, $val)){
                $ii++;
                $str[$ii] = $strarr[$ii]  . $char;
            } else {
                $str[$ii] = $strarr[$ii]  . $char;
            }
            $i++;
        }

        $l = 0;
        $position  = 0;

        foreach ($strarr as $letter) {
            $letter === strtoupper($letter) ?  $position = $l : null;
            $l++;
        }

        /*
        * zkontrolování jestli proměnná position není hodnoty 0, pokud ano, tak to znamená že předcházející foreach
        * zjistil zaznamenal jen jedno velké písmeno
        */

        $position !== 0 ? array_splice($strarr, $position , 0, "_" ) : null;

        $newStr = null;

        foreach ($strarr as $letter) {
            $newStr.= $letter;
        }

        return strtolower($newStr);

    }


}