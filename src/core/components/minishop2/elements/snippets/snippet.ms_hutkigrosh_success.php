<?php
/** @var modX $modx */

use esas\hutkigrosh\controllers\ControllerWebpayFormModxMinishop2;
use esas\hutkigrosh\wrappers\ConfigurationWrapperModxMinishop2;
use esas\hutkigrosh\wrappers\OrderWrapperModxMinishop2;

//require_once $GLOBALS["modx"]->getOption('base_path') . 'core/components/minishop2/custom/payment/lib/SimpleAutoloader.php';

/** @var array $scriptProperties */
$tpl = $modx->getOption('tpl', $scriptProperties, 'tpl.mspHutkigrosh.success');
$configuration = new ConfigurationWrapperModxMinishop2($modx);
$order = $modx->getObject('msOrder', $_GET['msorder']);
$orderWrapper = new OrderWrapperModxMinishop2($order);
$chunkProperties = array('order_number' => $orderWrapper->getOrderId());
if ($configuration->isWebpayButtonEnabled()) {
    $controller = new ControllerWebpayFormModxMinishop2($configuration);
    $webpayResp = $controller->process($orderWrapper->getBillId());
    $chunkProperties['webpay_button_enabled'] = true;
    $chunkProperties['webpay_status'] = $_GET['webpay_status']; // при возврате с webpay, статус передается в параметрах адреса
    $chunkProperties['webpay_form'] = $webpayResp->getHtmlForm(); // при возврате с webpay, статус передается в параметрах адреса
}
if ($configuration->isAlfaclickButtonEnabled()) {
    $chunkProperties['alfaclick_button_enabled'] = true;
    $chunkProperties['alfaclick_url'] = $modx->getOption('site_url') . "assets/components/minishop2/payment/hutkigrosh.php?action=alfaclick";
    $chunkProperties['alfaclick_phone'] = $orderWrapper->getMobilePhone();
    $chunkProperties['alfaclick_bill_id'] = $orderWrapper->getBillId();
}


/** @var pdoTools $pdoTools */
$pdoTools = $modx->getService('pdoTools');

return $pdoTools->getChunk($tpl, $chunkProperties);