<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 07.01.2019
 * Time: 20:54
 */

namespace App\Controllers\DevControllers;

use App\Controllers\RestApi;
use App\Controllers\TDatabaseFormatter;
use App\Database\Connection;
use App\Controllers\RestController;
use App\Database\DB;

class ModelController extends RestController
{
    use RestApi;
    use TDatabaseFormatter;
    private $preview;
    private $error;
    const MODEL_PREFIX_PATH = __DIR__ . '/../../Entities/';

    public function sendModelClassPreview()
    {
        $conn = new Connection();
        parent::sendJSON(["preview" => $this->preview ]);
    }

    public function finishGenerateModelClass()
    {
        $data = parent::receiveJSON();
        $model = $data["name"];
        $indexes = $data["indexes"];
        $db = DB::schema()->getPDO();
       
        while (!(rename(__DIR__ . '/../../Entities/DummyModel.stub', static::MODEL_PREFIX_PATH .  ucfirst($model) . '.php')))
        {
            sleep(2);
        }


        $migration = 'App\\Database\\Migrations\\Submigrations\\' . \ucfirst($model)  . 'Migration';
        $instance =  new $migration();
        $instance->up();

        $tableName = $this->formatModelName($model);
        $data = [];
        $count = count($indexes);

        if ($count > 1) {

            for($i = 0; $i < $count ; $i++){

                $index =    $indexes[$i]["index"];
                array_push($data, $index);
                $index ?  $db->query(sprintf("CREATE INDEX %s_index  ON  %s(%s)", $index ,$tableName, $index)) : null;
            }

        }
        else {
            $index = $indexes[0]["index"];
            $count === 1 ? $db->query(sprintf("CREATE INDEX %s_index  ON  %s(%s)", $index ,$tableName, $index)) : null;
        }




    }

    public function cancelOperation()
    {
        unlink(__DIR__ . "/../../Entities/DummyModel.stub");
    }

    public function generateModelClass()
    {
        $data = parent::receiveJSON();
        $model = $data["name"];


        if (copy(__DIR__ . '/../../Console/ComponentFactory/ClassTemplateStore/DummyModel.stub', __DIR__ . '/../../Entities/DummyModel.stub')) {
            $str = file_get_contents(__DIR__ . '/../../Entities/DummyModel.stub');

            //replace something in the file string - this is a VERY simple example
            $str = str_replace("DummyModel", \ucfirst($model), $str);

            //strcspn('aAple', 'ABCDEFGHJIJKLMNOPQRSTUVWXYZ');
            $str = str_replace("dummymodel", sprintf("%ss", $this->formatModelName($model)), $str);
            //require_once __DIR__ . "/../../Database/Migrations/" . $input->getArgument('model') . "Migration.php";

            $migration = 'App\\Database\\Migrations\\Submigrations\\' . \ucfirst($model) . 'Migration';

            $instance = new $migration();
            //$output->writeln("COUNT " . $migration);
            $dataSchemaStr = 'protected $dataSchema = [' . "\n";
            $numericOrder = 0;
            $count = count($instance->getFillableColumns());
            //$output->writeln("COUNT " . $count);
            foreach ($instance->getFillableColumns() as $key => $value) {
                if ($numericOrder !== $count - 1) {
                    $dataSchemaStr .= "         '" . $key . "' => '" . $value . "',\n";
                } else {
                    $dataSchemaStr .= "         '" . $key . "' => '" . $value . "'\n    ];";
                }
                $numericOrder++;
            }

            $search_1 = 'protected $dataSchema = [];';


            $search_2 = 'protected $fillable = [];';


            $columnsStr = 'protected $fillable = [' . "\n";
            $counter = 1;
            $max = count($instance->getFillableColumns());
            foreach ($instance->getFillableColumns() as $key => $value) {
                $columnsStr .= $counter !== $max
                    ? sprintf("         '%s',\n", $key)
                    : sprintf("         '%s'\n", $key);
                $counter++;
            }

            $columnsStr .= "    ];\n";

            $validationStr = 'protected static $validation = [' . "\n";


            $str = str_replace($search_1, $search_1 . $dataSchemaStr, $str);
            $str = str_replace($search_1, '', $str);

            $str = str_replace($search_2, $columnsStr, $str);
            $str = str_replace($search_2, '', $str);
            //write the entire string
            file_put_contents(__DIR__ . '/../../Entities/DummyModel.stub', $str);
            $this->preview = $str;
            $this->sendModelClassPreview();
        }
    }


    private function formatModelName($str):string
    {
        $count = strlen($str);

        $i = 0;
        $ii = 0;
        $strarr  = str_split($str);
        while ($i < $count) {
            $char = $strarr{$i};
            if (preg_match("[A-Z]", $char, $val)) {
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
            if ($l !== 0) {
                $letter === strtoupper($letter) ? $position = $l : null;
            }
            $l++;
        }

        $position !== 0 ? array_splice($strarr, $position, 0, "_") : null;

        $newStr = null;

        foreach ($strarr as $letter) {
            $newStr.= $letter;
        }

        return strtolower($newStr);
    }
}
