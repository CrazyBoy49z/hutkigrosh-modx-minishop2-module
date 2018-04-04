<?php
/** @var modX $modx */

use esas\hutkigrosh\controllers\modx\ControllerWebpayFormModxMinishop2;
use esas\hutkigrosh\wrappers\modx\ConfigurationWrapperModxMinishop2;
use esas\hutkigrosh\wrappers\modx\OrderWrapperModxMinishop2;

require_once $GLOBALS["modx"]->getOption('base_path') . 'core/components/minishop2/custom/payment/lib/SimpleAutoloader.php';

/** @var array $scriptProperties */
$tpl = $modx->getOption('tpl', $scriptProperties, 'tpl.mspHutkigrosh.success');

$order = $modx->getObject('msOrder', $_GET['msorder']);
$orderWrapper = new OrderWrapperModxMinishop2($order);
$controller = new ControllerWebpayFormModxMinishop2(new ConfigurationWrapperModxMinishop2($modx));
$webpayResp = $controller->process($orderWrapper->getBillId());

/** @var pdoTools $pdoTools */
$pdoTools = $modx->getService('pdoTools');

return $pdoTools->getChunk($tpl, array(
    'webpay_status' => $_GET['webpay_status'], // при возврате с webpay, статус передается в параметрах адреса
    'webpay_form' => $webpayResp->getHtmlForm(), // при возврате с webpay, статус передается в параметрах адреса
    'order_number' => $orderWrapper->getOrderId(),
    'alfaclick_url' => $modx->getOption('site_url') . "assets/components/minishop2/payment/hutkigrosh.php?action=alfaclick",
    'alfaclick_phone' => $orderWrapper->getMobilePhone(),
    'alfaclick_bill_id' => $orderWrapper->getBillId(),
));