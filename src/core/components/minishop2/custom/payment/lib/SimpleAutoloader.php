<?php

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 27.06.2018
 * Time: 16:18
 */
class SimpleAutoloader
{
    static public function loader($class)
    {
        $className = str_replace("\\", DIRECTORY_SEPARATOR, $class);
        $path = MODX_CORE_PATH . 'components/minishop2/custom/payment/lib/' . $className . '.php';
        if (file_exists($path)) {
            require_once($path);
            if (class_exists($class)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}

spl_autoload_register('SimpleAutoloader::loader');