<?php

namespace App\Database;


class BaseMigration
{

    use GetNamespaces;

    protected const TABLE = null;
    protected $sql;
    protected $dataSchema = [];
    protected static $columns = [];
    private $database;
    private $connect;
    protected $foreignKey;
    protected $_validation = [];
    protected static $validation = [];

    public static function getValidation()
    {
        return static::$validation;
    }

    public function setValidation()
    {
        $this->_validation = self::$validation;
    }

    protected function getForeignKey()
    {
        return $this->foreignKey;
    }

    protected static function getColumns()
    {
        return self::$columns;
    }

    public function setAvailableColumns()
    {
        self::$columns = $this->dataSchema;
    }

    public static function getFillable()
    {
        return self::$columns;
    }

    final public function __construct($connectionClass = null)
    {
        $connectionClass === null ? $connectionClass = Connection::whoAmI() : DevConnection::whoAmI();
        $class = $this->getConnectionNamespace($connectionClass);
        $instance = new $class();
        $this->connect= $instance->connect();
        $this->database = $this->connect;
        $this->setAvailableColumns();
        $this->setValidation();
        $this->setUp();

    }

    final public function getFillableColumns()
    {
        return $this->dataSchema;
    }

    final protected function setUp()
    {
        $this->sql = 'CREATE TABLE IF NOT EXISTS '. static::TABLE . '(';
        $numericOrder = 0;
        $count = count($this->dataSchema);

        foreach ($this->dataSchema as $key => $value) {
            if($numericOrder !== $count -1) {
                $this->sql .= $key;
                $this->sql .= ' ';
                $this->sql .= $value;
                $this->sql .= ',';

            }
            else {
                $this->sql .= $key;
                $this->sql .= ' ';
                $this->sql .= $value;
            }
            $numericOrder++;
        }
        $this->sql .= ')';
        $this->writeMigration($this->sql);
    }

    final public function getTableName()
    {
        return static::TABLE;
    }

    final public function up()
    {
        try {
            $this->database->query($this->getWritedMigration());
        }
        catch (\Exception $exception){
            return $exception;
        }
    }

    final public function down()
    {
        $this->sql = sprintf("DROP TABLE %s", self::TABLE);
        $this->database->query($this->sql);
    }

    final public function getWritedMigration():string 
    {
        return $this->sql;
    }

    final public function writeMigration(string $sql)
    {
        $this->sql = $sql;
    }

    protected function getKey($variable, $array)
    {

        foreach($array as $key => $value)
        {
            if(is_array($value))
            {
                $subarray = $value;

                foreach($subarray as $subvalue)
                {
                    if($subvalue == $variable)
                    {
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