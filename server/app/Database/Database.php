<?php
namespace App\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database {
    public function __construct()
    {
        $this->capsule = new Capsule;
        // Same as database configuration file of Laravel.
        $this->capsule->addConnection([
            'driver'   => getenv("DB_DRIVER"),
            'database' => __DIR__ . '/' . getenv("APP_DB"),
            'prefix'   => '',
        ], 'default');
        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        // Hold a reference to established connection just in case.
        $this->connection = $this->capsule->getConnection('default');
    }
}