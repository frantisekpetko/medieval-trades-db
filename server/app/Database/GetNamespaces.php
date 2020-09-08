<?php
namespace App\Database;

trait GetNamespaces
{
    public function getMigrationNamespace($namespace):string
    {
      
       return $namespace ===  "App\\Database\\DevDB"
       ?  'App\\Database\\Migrations\\Devsubmigrations\\'
       :  'App\\Database\\Migrations\\Submigrations\\';
    }

    public function getConnectionNamespace($class)
    {
        return $class === DevConnection::whoAmI()
            ?  DevConnection::whoAmI()
            :  Connection::whoAmI();
    }

    public function resolveDatabaseFile($class):string
    {
        return $class === DevDB::whoAmI() ?
            'DEV_DB' : "APP_DB";
    }


}
