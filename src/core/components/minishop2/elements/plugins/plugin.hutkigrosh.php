<?php
/** @var modX $modx */
switch ($modx->event->name) {
    // добавим автозагрузчик composer-а
    case 'OnMODXInit':
        $file = MODX_CORE_PATH . 'vendor/autoload.php';
        if (file_exists($file)) {
            require_once $file;
        }
        $file = MODX_CORE_PATH . 'components/minishop2/custom/payment/lib/SimpleAutoloader.php';
        if (file_exists($file)) {
            require_once $file;
        }
        Logger::configure(MODX_CORE_PATH . 'components/minishop2/custom/payment/lib/log4php-config.xml');
        break;
}
