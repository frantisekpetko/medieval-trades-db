<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 24.01.2019
 * Time: 9:00
 */

namespace App\Database;

use App\Database\DevConnection;
use App\Exceptions\DatabaseException;
use Symfony\Component\HttpFoundation\Session\Session;

class DB
{
    use GetNamespaces;

    static $staticDatabase;
    protected $database = null;
    protected static $_instance = null;
    protected static $migration;
    static protected $migrationNamespace;
    protected static $table;

    protected $session;
    public $databaseString;
    protected $sqlSelect;
    protected $foreignKey;
    protected $actualNamespace;
    protected $last;
    protected $sql;
    protected $limit;
    protected $columns;
    protected $databaseEnvAttr;
    protected $areColumns;

    protected $lastID;
    protected $oppositeTable;
    protected $primaryFK;
    protected $secondaryFK;
    protected $join;
    protected $array;

    protected function __construct() {
        //$this->session = new Session();
        //$this->session->start();
        $this->actualNamespace = get_class($this);
        $this->databaseString = sprintf('sqlite:%s%s%s', __DIR__ ,"/",   getenv("APP_DB"));
        $this->database = new \PDO($this->databaseString);
        $this->join = null;
        $this->foreignKey = null;
    }

    public function getConnectionString()
    {
        return $this->getConnectionString();
    }

    public function __destruct()
    {
        $this->database = null;
    }

    public function getErrorMessage():array
    {
        return $this->database->errorInfo();
    }


    public static function whoAmI() {
        return get_called_class();
    }


    public static function schema():DB
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }


    public function getPDO()
    {
        return $this->database;
    }


    public function setTempPDO()
    {
        self::$staticDatabase = $this->database;
    }

    static function returnForcePDO()
    {
        return self::$staticDatabase;
    }

    public static function table($name):DB
    {
        self::$table = $name;

        $useDevsubmigrations = false;

        $devTables = [
            "arguments",
            "unsafe_exceptions",
            "server_exceptions",
            "stack_traces",
            "client_errors"
        ];

        foreach ($devTables as $devTable){
            if ($devTable === self::$table ){
                $useDevsubmigrations = true;
                break;
            }
        }

        $useDevsubmigrations
            ? self::$migrationNamespace = 'App\\Database\\Migrations\\Devsubmigrations\\'
            : self::$migrationNamespace = 'App\\Database\\Migrations\\Submigrations\\';

        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        //$migrationNamespace = sprintf("\\App\\Database\\Migrations\\Submigrations\\%sMigration", ucfirst(self::$table));
        //self::$migration = new $migrationNamespace;
        //return self::$migrationNamespace;
        return self::$_instance;

    }

    public function last()
    {
        $this->last = true;
        return $this;
    }

    public function limit()
    {
        $this->limit = true;
        return $this;
    }

    public function select($columns)
    {
        $this->columns = func_get_arg($columns);

        $this->areColumns = true;
        return $this;
    }

    public function all()
    {
        $this->all = true;
        return $this;
    }


    public function create(array $array)
    {
        $this->array = $array;
        return $this;
    }


    public function createWithByOppositeForeignKey($foreignKey)
    {
        $this->foreignKey= $foreignKey;
        return $this;
    }

    public function finish()
    {
        if ($this->foreignKey === null)
        {
            $migrationString = self::$migrationNamespace . $this->transformTableToEntityString(self::$table)  . "Migration";
            $instance = new $migrationString();
            $columns = $instance->getFillableColumns();
            //$columns[] = $migrationClass::getColumns();

            $base_sql = "INSERT INTO ". self::$table . "(";
            $counter_key= 0;
            $counter_value = 0;
            $count = count($columns);
            foreach ($columns as $key => $value)
            {
                if ($key !== "id" && $key !== "created_at" && $key !== "updated_at")
                {
                    $counter_key < $count - 4 ? $base_sql .= $key . ", " : $base_sql .= $key;
                    $counter_key++;
                }

            }
            $base_sql .= ") VALUES (";


            foreach ($columns as $key => $value)
            {
                if ($key !== "id" && $key !== "created_at" && $key !== "updated_at")
                {
                    $counter_value < $count - 4  ? $base_sql .=  sprintf(':%s', $key) . ", " : $base_sql .=  sprintf(':%s', $key);
                    $counter_value++;
                }

            }
            $base_sql .= ")";

            $stmt = $this->database->prepare($base_sql);
            $exec = [];
            print_r($base_sql);
            foreach ($columns as $key => $value) {
                if ($key !== "id" && $key !== "created_at" && $key !== "updated_at"){

                    $id = sprintf(":%s", $key);
                    array_push($exec, [$id => $this->array[$key]]);
                    //var_dump([$id => $this->array[$key]]);
                    $validity = count($this->array);
                    if ($validity > 5  ){
                        try {
                            throw new DatabaseException("Empty values at create database operation was reached!");
                        }
                        catch(\Exception $e) {
                            throw new $e("Unspecified Exception.");
                        }

                    }
                    else {
                        $stmt->bindValue($id, $this->array[$key]);
                    }

                }
            }

            //$stmt->execute();
        }
        else
        {

            $migrationString = self::$migrationNamespace . $this->transformTableToEntityString(self::$table)  . "Migration";
            $instance = new $migrationString();
            $columns = $instance->getFillableColumns();


            $base_sql = "INSERT INTO ". self::$table . "(";
            $counter_key= 0;
            $counter_value = 0;
            $count = count($columns);
            foreach ($columns as $key => $value)
            {

               if ($key !== "id")
               {

                    $counter_key < $count - 2
                        ? $base_sql .= $key . ", "
                        : $base_sql .= $key;
                    $counter_key++;
               }


            }

            $base_sql .= ") VALUES (";


            foreach ($columns as $key => $value)
            {
                if ($key !== "id")
                {
                    $counter_value < $count - 2
                        ? $base_sql .=  sprintf(':%s,', $key)
                        : $base_sql .=  sprintf(':%s', $key);
                    $counter_value++;
                }


            }
            $base_sql .= ")";

            $stmt = $this->database->prepare($base_sql);
            //print_r($base_sql);
            $count = count($this->array);
            $counter = 0;

            foreach ($columns as $key => $value) {

                    $count - 1 === $counter
                        ? $id = sprintf(":%s", $key)
                        : $id = ":updated_at";
                    $count - 2 === $counter
                        ? $id = sprintf(":%s", $key)
                        : $id = ":created_at";

                    $counter++;


                if ($key !== "id") {
                    if ($key === "created_at"  || $key === "updated_at") {
                        $id = sprintf(":%s" , $key);
                        $stmt->bindValue($id, null);
                    } else {
                        if ($key === $this->foreignKey) {
                            $id = sprintf(":%s" , $this->foreignKey);
                            $stmt->bindValue( $id, $this->getLatestIDFromOppositeTable());
                        }
                        else {
                            $id = sprintf(":%s" , $key);
                            $stmt->bindValue($id, $this->array[$key]);
                            //var_dump( $this->array, $key);
                        }

                    }
                }

            }

            //$stmt->execute();
        }
        $stmt->execute();
        echo $stmt->queryString;
        var_dump($stmt->errorInfo());
        var_dump($stmt->debugDumpParams());
    }

    public function transferData()
    {
        $this->sqlSelect = "";

        $this->sqlSelect .= "SELECT ";

        if ($this->all()){
            $this->sqlSelect .= " * ";
        }
        else if ($this->areColumns)
        {
            $count = count($this->columns);
            $counter = 0;

            foreach($this->columns as $column)
            {
                $counter !== $count ?  $this->sqlSelect.= $column  :  $sql = $column . ",";
                $counter++;
            }
        }


        if (empty($this->last)) {
            if (!empty($this->limit)) {
                $this->sqlSelect .= " LIMIT " . $this->limit;
            }
        }

        if (!empty($this->last)) {
            $this->sqlSelect .= " WHERE id = (SELECT MAX(id)";
        }

        $this->sqlSelect .= " FROM " . static::$table;
        //$this->sql = $sql;

        $stmt = $this->database->query($this->sqlSelect);
        $results = [];

        while ($result = $stmt->fetchAll(\PDO::FETCH_ASSOC)) {
            $results[] = $result;
        }

        return $results;
    }

    public function getLatestID():int{
        $sql = "SELECT id FROM ". static::$table. " ORDER BY id DESC LIMIT 1";
        $stmt = $this->database->query($sql);
        $results = [];

        while ($result = $stmt->fetchAll(\PDO::FETCH_CLASS)) {
            $results[] = $result;
        }
        return $this->lastID = $results[0][0]->id;
    }

    public function getLatestIDFromOppositeTable(){
        $sql = "SELECT id FROM ". $this->transformForeignKeyToTable($this->foreignKey). " ORDER BY id DESC LIMIT 1";
        $stmt = $this->database->query($sql);
        $results = [];

        while ($result = $stmt->fetchAll(\PDO::FETCH_ASSOC)) {
            $results[] = $result;
        }

        return findKey($this->lastID = $results, "id")
            ? ($this->lastID = $results[0][0]["id"] !== null
                ? $this->lastID = $results[0][0]["id"] : 1) : 1;
    }

    public function transformForeignKeyToTable($foreignKey)
    {
        $oppositeTable = rtrim($foreignKey, "_id");
        $oppositeTable = sprintf("%s%s", $oppositeTable, "s");
        return $oppositeTable;
    }


    public function join($oppositeTable, $primaryFK, $secondaryFK){
        $this->oppositeTable = $oppositeTable;
        $this->primaryFK = $primaryFK;
        $this->secondaryFK = $secondaryFK;
        $this->join = "INNER";

        return $this;
    }

    public function addRelationship(
        $firstEntity,
        $secondEntity,
        $firstTable,
        $secondTable,
        $relationshipType,
        $isDevDatabase
    ):array {
        $error = [];
        $error2 = [];
        $tempID_1 = rand(1, 1024);
        do {
            $tempID_2 = rand(1, 1024);
        } while ($tempID_1 == $tempID_2);
        $_count = 0;
        $count = 0;
        $firstTempTableName = sprintf("%s_%u", $firstTable, $tempID_1);
        $secondTempTableName = sprintf("%s_%u", $secondTable, $tempID_2);
        $debug = null;
        $data = [
            [
                "index" => 0,
                "entity" => $firstEntity,
                "oppositeEntityLowerCase" => strtolower($secondEntity),
                "oppositeEntity" => $secondEntity,
                "oppositeTable" => $secondTable,
                "table" => $firstTable,
                "tempTable" => $firstTempTableName
            ],
            [
                "index" => 1,
                "entity" => $secondEntity,
                "oppositeEntityLowerCase" => strtolower($firstEntity),
                "oppositeEntity" => $firstEntity,
                "oppositeTable" => $firstTable,
                "table" => $secondTable,
                "tempTable" => $secondTempTableName
            ]
        ];

        $sqlDebug = [];

        switch ($relationshipType) {
            case "oneToOne":
                foreach ($data as $value) {
                    $currentClass = $isDevDatabase ? DevDB::whoAmI() : DB::whoAmI();
                    //$namespacex = str_replace('DB', '', $namespace);
                    //$namespacex = $namespacex . $currentClass;
                    $namespace = $this->getMigrationNamespace($currentClass);
                    $mn =  sprintf("%s%s%s",$namespace, $value["entity"],  "Migration");
                    //$mn = sprintf("%s%s%s", "App\\Database\\Migrations\\Submigrations\\", $_data["entity"], "Migration");
                    //$mn = sprintf("%s%s", $this->migrationNamespace, $_data["entity"] .  "Migration");
                    $migration = new $mn(new DevConnection());
                    $columns = $migration::getFillable();

                    ///$migrationNamespace = sprintf("\\App\\Database\\Migrations\\Submigrations\\%sMigration", "\\" . $value["entity"]);
                    ///$migration = new $migrationNamespace;
                    ///$columns = $migration::getFillable();

                    $sqlDefaultData = sprintf("PRAGMA table_info(%s)",  $value["table" ]);
                    $stmt = $this->database->query($sqlDefaultData);

                    $results = [];

                    while ($result = $stmt->fetchAll(\PDO::FETCH_ASSOC)) {
                        $results[] = $result;
                    }

                    $fk = [];
                    $columnsCount = count($results[0]);
                    $fillUp = false;

                    for ($q = 0; $q < $columnsCount; $q++) {

                        $fillUp ? array_push($fk, $results[0][$q]["name"]) : null;

                        if($results[0][$q]["name"] === "updated_at") {
                            $fillUp = true;
                        }
                    }

                    $sqlRename = sprintf(
                        "ALTER TABLE %s RENAME TO %s",
                        $value["tempTable"],
                        $value["table"]
                    );

                    $sqlCreateTable =
                        'CREATE TABLE  IF NOT EXISTS ' . $value["tempTable"] . '(';
                    $numericOrder = 0;
                    $count = count($columns);

                    foreach ($columns as $key => $column) {
                        if ($numericOrder !== $count - 1) {

                            $sqlCreateTable .= $key;
                            $sqlCreateTable .= ' ';
                            $sqlCreateTable .= $column;
                            $sqlCreateTable .= ',';
                        } else {

                            $sqlCreateTable .= $key;
                            $sqlCreateTable .= ' ';
                            $sqlCreateTable .= $column;




                            $sqlCreateTable .= ', ';
                            $this->foreignKey = $this->formatModelName($value["oppositeEntity"]). "_id";
                            $sqlCreateTable .= $this->foreignKey;
                            $sqlCreateTable .= ' ';
                            $sqlCreateTable .= "INTEGER";

                            if ($columnsCount > 0) {
                                foreach ($fk as $val) {
                                    $sqlCreateTable .= ', ';
                                    $this->foreignKey = $val;
                                    $sqlCreateTable .= $this->foreignKey;
                                    $sqlCreateTable .= ' ';
                                    $sqlCreateTable .= "INTEGER";

                                }

                            }

                            $sqlCreateTable .= ", ";
                            $sqlCreateTable .= sprintf("FOREIGN KEY(%s_id) REFERENCES %s('id')",$this->formatModelName($value["oppositeEntity"]), $value["oppositeTable"]);
                            if ($columnsCount > 0) {

                                foreach ($fk as $val) {
                                    //$sqlCreateTable .= ', ';
                                    $this->foreignKey = $val;
                                    $sqlCreateTable .= ", ";
                                    $sqlCreateTable .= sprintf("FOREIGN KEY(%s) REFERENCES %s('id')", $this->foreignKey, $this->transformFKToTableString($this->foreignKey));
                                }
                            }

                        }
                        $numericOrder++;
                    }
                    $sqlCreateTable .= ')';

                    //$sqlCreateTable = "CREATE TABLE {tableName} (name TEXT, COLNew {type} DEFAULT {defaultValue}, qty INTEGER, rate REAL)";
                    $sqlMoveData = "INSERT INTO " . $value["tempTable"] . " (";
                    $numericOrder = 0;
                    foreach ($columns as $key => $column) {
                        if ($numericOrder !== $count - 1) {
                            $sqlMoveData .= $key . ", ";
                        } else {
                            $sqlMoveData .= $key . ") "; // ", " . $this->foreignKey . ") ";
                        }
                        $numericOrder++;

                    }
                    $numericOrder = 0;
                    $count = count($columns);
                    $sqlMoveData .= "SELECT ";

                    foreach ($columns as $key => $column) {
                        if ($numericOrder !== $count - 1) {
                            $sqlMoveData .= $key . ", ";

                        }
                        else {
                            $sqlMoveData .= $key ; //.  ", " . $this->foreignKey//;
                        }
                        $numericOrder++;
                    }


                    $sqlMoveData .= " FROM " . $value["table"];

                    $sqlRemoveTempTable = sprintf(
                        "DROP TABLE  %s",
                        $value["table"]
                    );

                    $this->database->exec($sqlCreateTable);
                    array_push($error, $this->database->errorInfo());
                    $this->database->exec($sqlMoveData);
                    array_push($error, $this->database->errorInfo());
                    $this->database->exec($sqlRemoveTempTable);
                    array_push($error, $this->database->errorInfo());
                    $this->database->exec($sqlRename);
                    array_push($error, $this->database->errorInfo());

                    $value["index"] === 0 ?  array_push($sqlDebug, ["createTable" => $sqlCreateTable]) : null;
                    $value["index"] === 0 ?  array_push($sqlDebug, ["removeTempTable" => $sqlRemoveTempTable]): null;
                    $value["index"] === 0 ?  array_push($sqlDebug, ["moveData" => $sqlMoveData]): null;
                    $value["index"] === 0 ?  array_push($sqlDebug, ["rename" => $sqlRename]): null;
                }
                break;
            case "oneToMany":
                $_data = $data[0];
                
                //$migrationNamespace = sprintf("\\App\\Database\\Migrations\\Submigrations\\%sMigration", $value["entity"]);
                //$migration = new $migrationNamespace;
                //$columns = $migration::getFillable();
            
                //$actualNamespace = __CLASS__;
                //$namespace = $this->getMigrationNamespace(substr(get_called_class(), 0, strrpos(get_called_class(), "\\")));
                $currentClass = $isDevDatabase ? DevDB::whoAmI() : DB::whoAmI();
                //$namespacex = str_replace('DB', '', $namespace);
                //$namespacex = $namespacex . $currentClass;
                $namespace = $this->getMigrationNamespace($currentClass);
                $mn =  sprintf("%s%s%s", $namespace, $_data["entity"],  "Migration");
                //$mn = sprintf("%s%s%s", "App\\Database\\Migrations\\Submigrations\\", $_data["entity"], "Migration");
                //$mn = sprintf("%s%s", $this->migrationNamespace, $_data["entity"] .  "Migration");
                $migration = new $mn(new DevConnection());
                $columns = $migration::getFillable();

                $sqlRename = sprintf(
                    "ALTER TABLE %s RENAME TO %s",
                    $_data["tempTable"],
                    $_data["table"]
                );

                $sqlCreateTable =
                    'CREATE TABLE  IF NOT EXISTS ' . $_data["tempTable"] . '(';
                $numericOrder = 0;
                $count= count($columns);



                $sqlDefaultData = sprintf("PRAGMA table_info(%s)",  $_data["table"]);
                $stmt = $this->database->query($sqlDefaultData);

                $results = [];

                while ($result = $stmt->fetchAll(\PDO::FETCH_ASSOC)) {
                    $results[] = $result;
                }
                $fk = [];

                $fillUp = false;
                $columnsCount = count($results[0]);
                for ($l = 0; $l < $columnsCount; $l++) {

                    $fillUp ? array_push($fk, $results[0][$l]["name"]) : null ;

                    if($results[0][$l]["name"] === "updated_at") {
                        $fillUp = true;
                    }
                }

                foreach ($columns as $key => $column) {
                    if ($numericOrder !== $count - 1) {

                        $sqlCreateTable .= $key;
                        $sqlCreateTable .= ' ';
                        $sqlCreateTable .= $column;
                        $sqlCreateTable .= ',';
                    } else {

                        $sqlCreateTable .= $key;
                        $sqlCreateTable .= ' ';
                        $sqlCreateTable .= $column;

                        /*
                        if ($columnsCount > 0) {
                            foreach ($fk as $val) {
                                $sqlCreateTable .= ', ';
                                $this->foreignKey = $val;
                                $sqlCreateTable .= $this->foreignKey;
                                $sqlCreateTable .= ' ';
                                $sqlCreateTable .= "INTEGER";
                                $sqlCreateTable .= ", ";
                                $sqlCreateTable .= sprintf("FOREIGN KEY(%s) REFERENCES %s('id')",
                                    $this->foreignKey, $this->transformFKToTableString($this->foreignKey)
                                );
                            }

                        }
                        */

                        $sqlCreateTable .= ', ';
                        $this->foreignKey = $this->formatModelName($_data["oppositeEntity"]) . "_id";
                        $sqlCreateTable .=  $this->foreignKey;
                        $sqlCreateTable .= ' ';
                        $sqlCreateTable .= "INTEGER";

                        if($columnsCount > 0) {
                            foreach ($fk as $val) {
                                $sqlCreateTable .= ', ';
                                $this->foreignKey = $val;
                                $sqlCreateTable .= $this->foreignKey;
                                $sqlCreateTable .= ' ';
                                $sqlCreateTable .= "INTEGER";

                            }

                        }

                        $sqlCreateTable .= ", ";
                        $sqlCreateTable .= sprintf("FOREIGN KEY(%s_id) REFERENCES %s('id')",
                            $_data["oppositeEntityLowerCase"], $_data["oppositeTable"]//$this->transformForeignKeyToTable($this->foreignKey)
                        );

                        if ($columnsCount > 0) {
                            foreach ($fk as $val) {
                                //$sqlCreateTable .= ', ';
                                $this->foreignKey = $val;
                                $sqlCreateTable .= ", ";
                                $sqlCreateTable .= sprintf(
                                    "FOREIGN KEY(%s) REFERENCES %s('id')",
                                    $this->foreignKey, $this->transformFKToTableString($val)
                                );
                            }
                        }





                    }
                    $numericOrder++;
                }
                $sqlCreateTable .= ')';

                //$sqlCreateTable = "CREATE TABLE {tableName} (name TEXT, COLNew {type} DEFAULT {defaultValue}, qty INTEGER, rate REAL)";
                $sqlMoveData = "INSERT INTO " . $_data["tempTable"] . " (";
                $numericOrder = 0;
                foreach ($columns as $key => $column) {
                    if ($numericOrder !== $count - 1) {
                        $sqlMoveData .= $key . ", ";
                    } else {
                        $sqlMoveData .= $key  . ")"; // ", " . $this->foreignKey .") ";
                    }
                    $numericOrder++;

                }
                $numericOrder = 0;
                $_count = count($columns);
                $sqlMoveData .= " SELECT ";

                foreach ($columns as $key => $column) {
                    if ($numericOrder !== $_count - 1) {
                        $sqlMoveData .= $key . ", ";

                    }
                    else {
                        $sqlMoveData .= $key; //.", "  .  $this->foreignKey;
                    }
                    $numericOrder++;
                }


                $sqlMoveData .= " FROM " . $_data["table"];

                $sqlRemoveTempTable = sprintf(
                    "DROP TABLE  %s",
                    $_data["table"]
                );
              
                $this->database->exec($sqlCreateTable);
                array_push( $error2, $this->database->errorInfo());
                $this->database->exec($sqlMoveData);
                array_push( $error2, $this->database->errorInfo());
                $this->database->exec($sqlRemoveTempTable);
                array_push( $error2, $this->database->errorInfo());
                $this->database->exec($sqlRename);
                array_push( $error2, $this->database->errorInfo());

                $_data["index"] === 0 ?  array_push($sqlDebug, ["createTable" => $sqlCreateTable]) : null;
                $_data["index"] === 0 ?  array_push($sqlDebug, ["removeTempTable" => $sqlRemoveTempTable]): null;
                $_data["index"] === 0 ?  array_push($sqlDebug, ["moveData" => $sqlMoveData]): null;
                $_data["index"] === 0 ?  array_push($sqlDebug, ["rename" => $sqlRename]): null;
                break;
            case "manyToMany":
                $sqlCreateTable =
                    'CREATE TABLE IF NOT EXISTS ' .
                    $firstTable .
                    '_' .
                    $secondTable .
                    '(';
                //$numericOrder = 0;
                //$count = count($columns);

                $foreignKey_1 = $firstTable . "_id";
                $foreignKey_2 = $secondTable . "_id";

                $sqlCreateTable .= $foreignKey_1;
                $sqlCreateTable .= ' ';
                $sqlCreateTable .= "INTEGER";
                $sqlCreateTable .= ',';

                $sqlCreateTable .= $foreignKey_2;
                $sqlCreateTable .= ' ';
                $sqlCreateTable .= "INTEGER";
                $sqlCreateTable .= ',';

                $sqlCreateTable .= sprintf("FOREIGN KEY(%s) REFERENCES %s('id')", $foreignKey_1, $firstTable);
                $sqlCreateTable .= ',';
                $sqlCreateTable .= sprintf("FOREIGN KEY(%s) REFERENCES %s('id')", $foreignKey_2, $secondTable);

                $sqlCreateTable .= ')';
                $this->database->exec($sqlCreateTable);

                break;
            }
            return [
                "sqlCreate" => $sqlCreateTable,
                //"sqlMove" => $sqlMoveData,
                //"sqlRename" => $sqlRename,
                //"sqlRemove" => $sqlRemoveTempTable,
                "1:1" => $error,
                "1:N" => $error2,
                "foreignKey" => $this->foreignKey,
                "defaulTable" => $results,
                //"_count" => $_count,
                "count" => $columnsCount,
                "fk" => $fk,
                "sqlDebug" => $sqlDebug,
                //"updated_at" => $results[0][3]["name"],
                "dev" =>  $isDevDatabase ? DevDB::whoAmI() : DB::whoAmI()
                
            ];
        }


        private function transformFKToTableString(string $fk):string
        {
            $table = rtrim($fk,'id');
            $table = sprintf("%ss",rtrim($table, "_" ) );
            return $table;
        }


        private function transformEntityToTableString(string $entity):string
        {
            function isPartUppercase($string) {
            return (bool) preg_match('/[A-Z]/', $string);
            }


            $charsEntity = [];
            $_charsEntity = str_split($entity);
            $order = 0;
            $counter = 0;

            foreach ($_charsEntity as $char)
            {
                if(isPartUppercase($char)) {
                    $counter++;
                }

                if($counter > 1){
                    if(isPartUppercase($char)) {
                        $charsEntity[$order] = "_";
                        $charsEntity[$order + 1] = strtolower($char);
                    }
                }
                else{
                    $charsEntity = $char;
                }

                $order++;
            }

            return sprintf("%ss", implode("", $charsEntity));
        }

        private function transformTableToEntityString(string $table):string
        {
            $table = rtrim($table,'s');
            if (strpos($table, '_') !== false) {
                $tableName = explode("_", $table);
                $table = ucfirst($tableName[0]) . ucfirst($tableName[1]);
                return $table;

            }
            return ucfirst($table);
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
