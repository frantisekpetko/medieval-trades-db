<?php


namespace App\Database;


class DevDB extends DB
{
    static $openDB = false;

    protected function __construct() {
        $this->database = new PDO(sprintf('sqlite:%s', __DIR__ . "/" .  getenv('DEV_DB')));
        self::$openDB = true;
        parent::__construct();
    }

    public function __destruct()
    {
        self::$openDB = false;
    }


    public static function whoAmI() {
        return get_called_class();
    }

}