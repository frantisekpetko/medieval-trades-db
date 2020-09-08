<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 23.11.2018
 * Time: 4:00
 */

namespace App\Database\Migrations;

use App\Database\BaseMigration;
use App\Console\ComponentFactory\GenerateModelClassCommand;

class MainMigration extends BaseMigration
{

    const TABLENAME = "table";

    /**
     *
     */
    public function run()
    {
        $instance = null;
        $cloned_class = $this->withTables();
        $model_cmd = new GenerateModelClassCommand();

        $log_directory = __DIR__ . "/Submigrations";

        foreach(glob($log_directory.'/*.*') as $file) {
            if ($instance !== null) {
                unset($instance);
            }

            $pos = strrpos($file, '/');
            $name = $pos === false ? $file : substr($file, $pos);

            $name = str_replace("/", "", $name);
            $name = str_replace(".php", "", $name);

            $class = 'App\\Database\\Migrations\\Submigrations\\' . (string)$name;

            $instance = new $class();
            $table = $instance->getTableName();

            $attr = static::TABLENAME . "_" . $table;
            //$this->dump($cloned_class->$attr);
            $model_cmd->command($cloned_class->$attr);
        }



    }

    public function withTables()
    {

        $instance = null;
        $copy = null;
        $log_directory = __DIR__ . "/Submigrations";

        $copy = clone $this;


        foreach(glob($log_directory.'/*.*') as $file) {
            if ($instance !== null) {
                unset($instance);
            }

            $pos = strrpos($file, '/');
            $name = $pos === false ? $file : substr($file, $pos);

            $name = str_replace("/", "", $name);
            $name = str_replace(".php", "", $name);

            $class = 'App\\Database\\Migrations\\Submigrations\\' . (string)$name;

            $instance = new $class();
            $table = $instance->getTableName();
            $attr = static::TABLENAME . "_" . $table;
            $copy->$attr = $table;
        }

        return $copy;

    }

    public function dump($dump){
        var_dump($dump);
        exit;
    }

}