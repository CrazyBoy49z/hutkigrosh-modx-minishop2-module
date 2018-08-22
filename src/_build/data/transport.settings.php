<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 12.03.2018
 * Time: 14:34
 */
if(!class_exists('EsasAutoloader')) {
    require_once dirname(dirname(dirname(__FILE__))) . '/core/components/minishop2/custom/payment/lib/EsasAutoloader.php';
}

use esas\hutkigrosh\ConfigurationFieldsModx;

$settings = array();
$tmp = array(
    ConfigurationFieldsModx::SHOP_NAME => array(
        'xtype' => 'textfield',
        'value' => '',
    ),
    ConfigurationFieldsModx::LOGIN => array(
        'xtype' => 'textfield',
        'value' => '',
    ),
    ConfigurationFieldsModx::PASSWORD => array(
        'xtype' => 'text-password',
        'value' => '',
    ),
    ConfigurationFieldsModx::ERIP_ID => array(
        'xtype' => 'textfield',
        'value' => '',
    ),
    ConfigurationFieldsModx::SANDBOX => array(
        'xtype' => 'combo-boolean',
        'value' => 'false',
    ),
    ConfigurationFieldsModx::EMAIL_NOTIFICATION => array(
        'xtype' => 'combo-boolean',
        'value' => 'false',
    ),
    ConfigurationFieldsModx::SMS_NOTIFICATION => array(
        'xtype' => 'combo-boolean',
        'value' => 'false',
    ),
    ConfigurationFieldsModx::BILL_STATUS_PENDING => array(
        'xtype' => 'numberfield',
        'value' => '',
    ),
    ConfigurationFieldsModx::BILL_STATUS_PAYED => array(
        'xtype' => 'numberfield',
        'value' => '',
    ),
    ConfigurationFieldsModx::BILL_STATUS_FAILED => array(
        'xtype' => 'numberfield',
        'value' => '',
    ),
    ConfigurationFieldsModx::BILL_STATUS_CANCELED => array(
        'xtype' => 'numberfield',
        'value' => '',
    ),
    ConfigurationFieldsModx::ALFACLICK_BUTTON => array(
        'xtype' => 'combo-boolean',
        'value' => 'false',
    ),
    ConfigurationFieldsModx::WEBPAY_BUTTON => array(
        'xtype' => 'combo-boolean',
        'value' => 'false',
    ),
    ConfigurationFieldsModx::DUE_INTERVAL=> array(
        'xtype' => 'numberfield',
        'value' => '',
    ),
    ConfigurationFieldsModx::SUCCESS_RESOURCE_ID => array(
        'xtype' => 'numberfield',
        'value' => '',
    ),
    ConfigurationFieldsModx::FAILED_RESOURCE_ID => array(
        'xtype' => 'numberfield',
        'value' => '',
    ),
);
foreach ($tmp as $k => $v) {
    /* @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(
        array(
            'key' => 'ms2_msp' . $k,
            'namespace' => 'minishop2',
            'area' => 'ms2_payment',
        ), $v
    ), '', true, true);
    $settings[] = $setting;
}
unset($tmp);
return $settings;