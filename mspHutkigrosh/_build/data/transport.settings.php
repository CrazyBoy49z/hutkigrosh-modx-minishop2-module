<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 12.03.2018
 * Time: 14:34
 */

$settings = array();
$tmp = array(
    'shop_name' => array(
        'xtype' => 'textfield',
        'value' => '',
    ),
    'hg_login' => array(
        'xtype' => 'textfield',
        'value' => '',
    ),
    'hg_password' => array(
        'xtype' => 'text-password',
        'value' => '',
    ),
    'erip_id' => array(
        'xtype' => 'textfield',
        'value' => '',
    ),
    'sandbox' => array(
        'xtype' => 'combo-boolean',
        'value' => 'false',
    ),
    'notification_email' => array(
        'xtype' => 'combo-boolean',
        'value' => 'false',
    ),
    'notification_sms' => array(
        'xtype' => 'combo-boolean',
        'value' => 'false',
    ),
    'bill_status_pending' => array(
        'xtype' => 'numberfield',
        'value' => '',
    ),
    'bill_status_payed' => array(
        'xtype' => 'numberfield',
        'value' => '',
    ),
    'bill_status_failed' => array(
        'xtype' => 'numberfield',
        'value' => '',
    ),
    'bill_status_canceled' => array(
        'xtype' => 'numberfield',
        'value' => '',
    ),
    'success_resource_id' => array(
        'xtype' => 'numberfield',
        'value' => '',
    ),
    'failed_resource_id' => array(
        'xtype' => 'numberfield',
        'value' => '',
    ),
);
foreach ($tmp as $k => $v) {
    /* @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(
        array(
            'key' => 'ms2_msphutkigrosh_' . $k,
            'namespace' => 'minishop2',
            'area' => 'ms2_payment',
        ), $v
    ), '', true, true);
    $settings[] = $setting;
}
unset($tmp);
return $settings;