<?php


namespace App\Database;


class DataManager
{

    protected $schema = false;
    protected $connection;
    protected $isReqRelationship;
    protected $firstTable;
    protected $secondTable;
    protected $firstEntity;
    protected $secondEntity;
    protected $relationshipType;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->database = $connection->connect();

    }

    public function schema()
    {
        $this->schema = true;
        return $this;
    }

    public function finalize(){

        if ($this->schema && $this->isReqRelationship ){

            $tempID_1 = rand(1, 1024);
            do {
                $tempID_2 = rand(1, 1024);
            } while ($tempID_1 == $tempID_2);

            $firstTempTableName = sprintf("%u_%s", $this->firstTable, $tempID_1);
            $secondTempTableName = sprintf("%u_%s", $this->secondTable, $tempID_2);

            $data = [
                [
                    "entity" => $this->firstEntity,
                    "oppositeEntityLowerCase" => strtolower($this->secondEntity),
                    "oppositeTable" => $this->secondTable,
                    "table" => $this->firstTable,
                    "tempTable" => $firstTempTableName
                ],
                [
                    "entity" => $this->secondEntity,
                    "oppositeEntityLowerCase" => strtolower($this->firstEntity),
                    "oppositeTable" => $this->firstTable,
                    "table" => $this->secondTable,
                    "tempTable" => $secondTempTableName
                ]
            ];

            switch ($this->relationshipType) {
                case "oneToOne":
                    foreach ($data as $value) {
                        $migrationNamespace = sprintf("\\App\\Database\\Migrations\\Submigrations\\%sMigration", $value["entity"]);
                        $migration = new $migrationNamespace;
                        $columns = $migration::getFillable();

                        $sqlRename = sprintf(
                            "ALTER TABLE %s RENAME TO %s",
                            $value["table"],
                            $value["tempTable"]
                        );

                        $sqlCreateTable =
                            'CREATE TABLE  IF NOT EXISTS ' . $value["table"] . '(';
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

                                $sqlCreateTable .= $value["oppositeEntityLowerCase"] . "_id";
                                $sqlCreateTable .= ' ';
                                $sqlCreateTable .= "INTEGER";
                                $sqlCreateTable .= sprintf("FOREIGN KEY(%s_id) REFERENCES %s(id)", $value["oppositeTable"], $value["oppositeTable"]);
                            }
                            $numericOrder++;
                        }
                        $sqlCreateTable .= ')';

                        $cols = "(";
                        $count = count($columns);
                        $counter = 0;
                        foreach ($columns as $key => $column){

                            if ($counter <= $count) {
                                $cols .= $key . ",";
                                $counter++;
                            }
                            else {
                                $cols .= $key . ")";
                                $counter++;
                            }

                        }
                        $sqlMoveData = sprintf(
                            "INSERT INTO %s %s SELECT * FROM %s",
                            $cols, $value["table"], $value["tempTable"]
                        );
                        $sqlRemoveTempTable = sprintf(
                            "DROP TABLE  %s",
                            $value["tempTable"]
                        );

                        $this->database->exec($sqlRename);
                        $this->database->exec($sqlCreateTable);
                        $this->database->exec($sqlMoveData);
                        $this->database->exec($sqlRemoveTempTable);
                    }
                    break;
                case "oneToMany":
                    nothingDo();
                    break;
                case "manyToMany":
                    $sqlCreateTable =
                        'CREATE TABLE IF NOT EXISTS ' .
                        $this->firstTable .
                        '_' .
                        $this->secondTable .
                        '(';
                    //$numericOrder = 0;
                    //$count = count($columns);

                    $foreignKey_1 = $this->firstTable . "_id";
                    $foreignKey_2 = $this->secondTable . "_id";

                    $sqlCreateTable .= $foreignKey_2;
                    $sqlCreateTable .= ' ';
                    $sqlCreateTable .= "INTEGER";
                    $sqlCreateTable .= ',';

                    $sqlCreateTable .= $foreignKey_2;
                    $sqlCreateTable .= ' ';
                    $sqlCreateTable .= "INTEGER";
                    $sqlCreateTable .= ',';

                    $sqlCreateTable .= sprintf("FOREIGN KEY(%s) REFERENCES %s(id)", $foreignKey_1, $this->firstTable);
                    $sqlCreateTable .= sprintf("FOREIGN KEY(%s) REFERENCES %s(id)", $foreignKey_2, $this->secondTable);
                    $sqlCreateTable .= ',';
                    $sqlCreateTable .= ')';
                    $this->database->exec($sqlCreateTable);
                    break;

            }
            function nothingDo(){
            }
        }
        return true;
    }


    public function addRelationship(
        $firstEntity,
        $secondEntity,
        $firstTable,
        $secondTable,
        $relationshipType
    ) {
        $this->isReqRelationship = true;
        $this->firstEntity = $firstEntity;
        $this->secondEntity = $secondEntity;
        $this->firstTable = $firstTable;
        $this->secondTable = $secondTable;
        $this->relationshipType = $relationshipType;
        return $this;
    }


}