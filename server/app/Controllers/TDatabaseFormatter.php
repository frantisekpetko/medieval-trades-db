<?php


namespace App\Controllers;


trait TDatabaseFormatter
{

    private function formatModelName($str):string{

        $count = strlen($str);

        $i = 0;
        $ii = 0;
        $strarr  = str_split($str);
        while($i < $count)
        {
            $char = $strarr{$i};
            if(preg_match("[A-Z]", $char, $val)){
                $ii++;
                $str[$ii] = $strarr[$ii]  . $char;
            } else {
                $str[$ii] = $strarr[$ii]  . $char;
            }
            $i++;
        }

        $l = 0;
        $position  = 0;

        foreach ($strarr as $letter) {
            $letter === strtoupper($letter) ?  $position = $l : null;
            $l++;
        }

        /*
        * zkontrolování jestli proměnná position není hodnoty 0, pokud ano, tak to znamená že předcházející foreach
        * zjistil zaznamenal jen jedno velké písmeno
        */

        $position !== 0 ? array_splice($strarr, $position , 0, "_" ) : null;

        $newStr = null;

        foreach ($strarr as $letter) {
            $newStr.= $letter;
        }

        return strtolower($newStr);

    }

}