<?php
/** @var modX $modx */

use esas\hutkigrosh\utils\LoggerDefault;

switch ($modx->event->name) {
    // добавим автозагрузчик composer-а
    case 'OnMODXInit':
        $file = MODX_CORE_PATH . 'components/minishop2/custom/payment/lib/EsasAutoloader.php';
        if (file_exists($file)) {
            require_once $file;
        }
        LoggerDefault::init(); // используем настройки по умолчанию для сохранения логов в безопасном каталоге
        break;
}
