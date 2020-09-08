<?php
namespace App\Database;
use PDO;

class Connection {

    private $database;


    public function __construct()
    {
        $db = __DIR__ . "/" . getenv('APP_DB');
        $dir = sprintf('sqlite:%s', $db);
        $this->database = new PDO($dir);


        //$this->database = new SQLite3("sqlite:" . getenv('DATABASE_SQLITE_PATH'));
    }

    public function connect(){

        return $this->database;
    }

    public function __destruct()
    {
        $this->database = null;
    }

    public static function whoAmI() {
        return get_called_class();
    }

}

