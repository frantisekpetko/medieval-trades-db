<?php


namespace App\Controllers\DevControllers;

use App\Controllers\RestController;
use App\Database\DB;
//use function App\Database\isPartUppercase;

class RelationshipController extends RestController
{

    const MODEL_DIR = __DIR__ . "/../../Models";
    private $modelNames;

    public function getAvailableCollectionNamesOfModels()
    {

        $this->modelNames = [];
        if ($handle = opendir(static::MODEL_DIR)) {

            while (false !== ($entry = readdir($handle))) {

                if ($entry != "." && $entry != "..") {
                    $entryWthoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $entry);
                    array_push($this->modelNames,$entryWthoutExt);
                }
            }
            closedir($handle);
        }

        parent::sendJSON(["modelNames" => $this->modelNames]);
    }

    public function generateRelationshipBetweenEntities()
    {

        $data = parent::receiveJSON();
        $firstEntity = $data["firstEntity"];
        $secondEntity = $data["secondEntity"];
        $relationshipType = $data["relationship"];
        $isDevDatabase = false;

        //$firstTable = sprintf("%ss", strtolower($firstEntity));
        //$secondTable =sprintf("%ss", strtolower($secondEntity));


        $firstTable = $this->transformEntityToTableString($firstEntity);
        $secondTable = $this->transformEntityToTableString($secondEntity);


        $debug = DB::schema()
              ->addRelationship(
                  $firstEntity,
                  $secondEntity,
                  $firstTable,
                  $secondTable,
                  $relationshipType,
                  $isDevDatabase
              );

        parent::sendJSON(["rel" => $debug]);
    }


    private function isCharUppercase($string) {
        return (bool) preg_match('/[A-Z]/', $string);
    }


    private function transformEntityToTableString(string $entity):string
    {

        $count = strlen($entity);
        $result = "";

        for ($i = 0; $i < $count; $i++)
        {
            if($this->isCharUppercase($entity[$i])) {
                if($i > 0) {
                    $result .= "_";
                }
            }

            $result .= strtolower($entity[$i]);
        }

        return sprintf("%ss", $result);
    }




}