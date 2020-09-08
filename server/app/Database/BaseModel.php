<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 14.10.2018
 * Time: 17:07
 */

namespace App\Database;
use App\Exceptions\DatabaseException;


class BaseModel
{

    protected const TABLE = null;
    protected $migration;

    protected $fillable;
    protected $database;
    protected $connection;
    protected $result;
    protected $sql;

    protected $selectables = [];
    protected $table;
    protected $whereClause;
    protected $limit;
    protected $last;
    protected $all;
    protected $sqlSelect;
    protected $foreignKey;
    protected $actualNamespace;
    protected $columns;
    protected $databaseEnvAttr;
    protected $areColumns;

    protected $lastID;
    protected $oppositeTable;
    protected $primaryFK;
    protected $secondaryFK;
    protected $join;
    protected $array;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->database = $connection->connect();
        $migrationNamespace = sprintf("\\App\\Database\\Migrations\\Submigrations\\%sMigration", ucfirst(static::TABLE));
        $this->migration = new $migrationNamespace;

    }


    public function all() {
        $this->all = true;

        //$this->select = func_get_args();
        return $this;
    }

    public function from($table) {
        $this->table = static::TABLE;
        return $this;
    }

    public function where($where) {
        $this->whereClause = $where;
        return $this;
    }

    public function limit($limit) {
        $this->limit = $limit;
        return $this;
    }

    public function last()
    {
        $this->last = true;
        return $this;
    }

    public function transferData()
    {
        $this->sql = "SELECT ";
        $sql = "";

        $numericOrder = 0;
        $columns = $this->migration->getFillableColumns();
        $count = count($columns);
        $sql .=  "SELECT ";
            foreach ($columns as $key => $value) {
                if($numericOrder !== $count - 1) {
                    $sql = $sql . $key . ", ";
                }
                else {
                    $this->sql = $sql;
                    $sql = $sql . $key . " ";
                }
                $numericOrder++;
            }
            $this->sql .= $sql;


        if (empty($this->all)) {
            if (!empty($this->whereClause)) {
                $sql .= " WHERE " . $this->whereClause;
            }

            if (!empty($this->limit)) {
                $this->sql[] = "LIMIT";
                $this->sql[] = $this->limit;
                $sql .= " LIMIT " . $this->limit;
            }

            if (!empty($this->last)) {
                $sql .= " WHERE id = (SELECT MAX(id)" . $this->whereClause;

            }

        }
        $sql .= " FROM " . static::TABLE;
        $this->sql = $sql;

        $stmt = $this->database->query($this->sql);
        $results= [];


        while($result= $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $results[] = $result;

        }


        return $results;

        //return $results;

        /*
        $sql = "SELECT ";
        $numericOrder = 0;
        $count = count($this->fillable);
        foreach ($this->fillable as $key => $value) {
            if($numericOrder !== $count - 1) {
                $sql = $sql . $key . ", ";
            }
            else {
                $this->sql = $sql;
                $sql = $sql . $key . " FROM " . static::TABLE;
            }
            $numericOrder++;
        }

        $stmt = $this->database->query($sql);
        $results= [];

        while($result= $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $results[] = $result;

        }

        return $results;

        */
    }


    /**
     * @param array $array
     * @throws DatabaseException
     */
    public function create(array $array)
    {

        $this->array = $array;
        return $this;
    }


    /**
     * @return mixed
     */
    public function finish()
    {
        $columns = $this->migration->getFillableColumns();

        //$columns[] = $migrationClass::getColumns();

        $base_sql = "INSERT INTO ". static::TABLE. "(";
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
                $counter_value < $count - 4  ? $base_sql .=  /*":" . $key*/ sprintf(':%s',$key) . ", " : $base_sql .=  sprintf(':%s', $key)/*":".$key*/;
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
                var_dump([$id => $this->array[$key]]);
                $validity = count($this->array);
                if ($validity <= 2  ){
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


        return $stmt->execute();

    }

    public function find(string $criterium, string $parameter)
    {

        $this->database->exec(sprintf("SELECT * FROM %s WHERE %s='%s'", self::TABLE, $criterium, $parameter));
        return $this;
    }

    public function delete(string $criterium, string $parameter)
    {

        $this->database->exec(sprintf("DELETE FROM %s WHERE %s='%s'", self::TABLE, $criterium, $parameter));
        return $this;
    }



    public function update($array)
    {
        //$x = "UPDATE COMPANY set SALARY = 25000.00 where ID=1";
        //$sql = sprintf("UPDATE %s set x = 25000.00 where %s=1", static::TABLE, );
        /*$this->database->exec();
        if(!$ret) {
            echo $db->lastErrorMsg();
        }*/
    }

    final protected function getKey($variable, $array) {

        foreach($array as $key => $value)
        {
            if(is_array($value))
            {
                $subarray = $value;

                foreach($subarray as $subvalue)
                {
                    if($subvalue == $variable)
                    {
                        //echo $key;
                        break 2;
                    }
                }
            }
            else
            {
                if($value ==  $variable)
                {
                    return $key;
                    break;
                }
            }
        }
        return null;
    }
}