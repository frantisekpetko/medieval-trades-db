<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 23.11.2018
 * Time: 4:00
 */

namespace App\Database\Seeds;

use App\Database\IBaseSeeder;

class MainSeeder implements IBaseSeeder
{
    const TABLENAME = "table";

    public function run()
    {
        $instance = null;
        $log_directory = __DIR__ . "/Subseeds";

        foreach(glob($log_directory.'/*.*') as $file) {
            if ($instance !== null) {
                unset($instance);
            }

            $pos = strrpos($file, '/');
            $name = $pos === false ? $file : substr($file, $pos);

            $name = str_replace("/", "", $name);
            $name = str_replace(".php", "", $name);

            $class = 'App\\Database\\Seeds\\Subseeds\\' . (string) $name;

            $seed_instance = new $class();
            $seed_instance->run();
        }
    }

}