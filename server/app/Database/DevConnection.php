<?php
namespace App\Database;
use PDO;

class DevConnection {

    public $database;


    public function __construct()
    {
        $this->database = new \PDO(sprintf('sqlite:%s', __DIR__ . "/" . getenv('DEV_DB')));

    }

    public function connect(){

        return $this->database;
    }

    public static function whoAmI() {
        return get_called_class();
    }

    public function __destruct()
    {
        $this->database = null;
    }

}

