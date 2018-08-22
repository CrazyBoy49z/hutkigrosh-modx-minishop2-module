<?php

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 27.06.2018
 * Time: 16:18
 */

require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/vendor/autoload.php';

class EsasAutoloader
{
    static public function loader($class)
    {
        $className = str_replace("\\", DIRECTORY_SEPARATOR, $class);
        // вместо MODX_CORE_PATH используется относительный путь
        // для возможности подключения EsasAutoloader на этапе сборки транспортного пакета (в скриптах папки _build)
        $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . $className . '.php';
        if (file_exists($path)) {
            require_once($path);
            if (class_exists($class)) {
                return TRUE;
            }
        }
        return FALSE;
    }
}

spl_autoload_register('EsasAutoloader::loader');