<?php
/**
 * Created by PhpStorm.
 * User: Derid
 * Date: 30.11.2018
 * Time: 23:35
 */


if (!function_exists('is_ssl')) {
    function is_ssl(){

        if($_SERVER['https'] == 1) /* Apache */ {
            return true;
        } elseif ($_SERVER['https'] == 'on') /* IIS */ {
            return true;
        } elseif ($_SERVER['SERVER_PORT'] == 443) /* others */ {
            return true;
        } else {
            return false; /* just using http */
        }

    }
}

if (!function_exists('dd')) {
    function dd()
    {
        echo '<pre>';
        array_map(function($x) { var_dump($x); }, func_get_args());
        die;
    }
}

if (!function_exists('ddx')) {
    function ddx()
    {
        echo '<pre>';
        array_map(function($x) { var_dump($x); }, func_get_args()); exit;
        //die;
    }
}
if (!function_exists('typeCast')) {
    function typecast($old_object, $new_classname)
    {
        if (class_exists($new_classname)) {
            $old_serialized_object = serialize($old_object);
            $old_object_name_length = strlen(get_class($old_object));
            $subtring_offset = $old_object_name_length + strlen($old_object_name_length) + 6;
            $new_serialized_object  = 'O:' . strlen($new_classname) . ':"' . $new_classname . '":';
            $new_serialized_object .= substr($old_serialized_object, $subtring_offset);
            return unserialize($new_serialized_object);
        } else {
            return false;
        }
    }
}

if (!function_exists('findKey')) {
    function findKey($array, $keySearch)
    {
        foreach ($array as $key => $item) {
            if ($key == $keySearch) {
                return true;
            } elseif (is_array($item) && findKey($item, $keySearch)) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('unaccent')) {
    function unaccent($string)
    {
        $input = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $input = preg_replace('/[^a-zA-Z0-9]/', '-', $input);
        return lcfirst($input);
    }
}