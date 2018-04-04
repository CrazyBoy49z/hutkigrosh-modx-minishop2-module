<?php

use esas\hutkigrosh\wrappers\modx\ConfigurationWrapperModxMinishop2;
use esas\hutkigrosh\controllers\modx\ControllerNotifyModxMinishop2;
use esas\hutkigrosh\controllers\ControllerAlfaclick;

if (!isset($modx)) {
    define('MODX_API_MODE', true);
    require dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/index.php';

    $modx->getService('error', 'error.modError');
    $modx->setLogLevel(modX::LOG_LEVEL_ERROR);
}
require_once $GLOBALS["modx"]->getOption('base_path') . 'core/components/minishop2/custom/payment/lib/SimpleAutoloader.php';
$modx->error->message = null;

switch ($_GET['action']) {
    case 'alfaclick':
        $controller = new ControllerAlfaclick(new ConfigurationWrapperModxMinishop2($modx));
        $controller->process($_REQUEST['bill_id'], $_REQUEST['phone']);
        break;
    case 'notify':
        $controller = new ControllerNotifyModxMinishop2(new ConfigurationWrapperModxMinishop2($modx));
        $controller->process($_REQUEST['purchaseid']);
        break;
}




