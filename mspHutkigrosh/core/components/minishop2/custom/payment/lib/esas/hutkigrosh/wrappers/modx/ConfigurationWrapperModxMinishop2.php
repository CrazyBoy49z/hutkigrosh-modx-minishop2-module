<?php

namespace esas\hutkigrosh\wrappers\modx;

use esas\hutkigrosh\wrappers\ConfigurationWrapper;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 13.03.2018
 * Time: 14:44
 */
class ConfigurationWrapperModxMinishop2 extends ConfigurationWrapper
{
    const CONFIG_HG_SHOP_NAME = 'ms2_msphutkigrosh_shop_name';
    const CONFIG_HG_LOGIN = 'ms2_msphutkigrosh_hg_login';
    const CONFIG_HG_PASSWORD = 'ms2_msphutkigrosh_hg_password';
    const CONFIG_HG_ERIP_ID = 'ms2_msphutkigrosh_erip_id';
    const CONFIG_HG_SANDBOX = 'ms2_msphutkigrosh_sandbox';
    const CONFIG_HG_EMAIL_NOTIFICATION = 'ms2_msphutkigrosh_notification_email';
    const CONFIG_HG_SMS_NOTIFICATION = 'ms2_msphutkigrosh_notification_sms';
    const CONFIG_HG_PAYMENT_METHOD_NAME = 'ms2_msphutkigrosh_payment_method_description';
    const CONFIG_HG_PAYMENT_METHOD_DESCRIPTION = 'ms2_msphutkigrosh_payment_method_description';
    const CONFIG_HG_BILL_STATUS_PENDING = 'ms2_msphutkigrosh_bill_status_pending';
    const CONFIG_HG_BILL_STATUS_PAYED = 'ms2_msphutkigrosh_bill_status_payed';
    const CONFIG_HG_BILL_STATUS_FAILED = 'ms2_msphutkigrosh_bill_status_failed';
    const CONFIG_HG_BILL_STATUS_CANCELED = 'ms2_msphutkigrosh_bill_status_canceled';

    const CONFIG_HG_SUCCESS_RESOURCE_ID = 'ms2_msphutkigrosh_success_resource_id';
    const CONFIG_HG_FAILED_RESOURCE_ID = 'ms2_msphutkigrosh_failed_resource_id';

    public $modx;

    /**
     * ConfigurationWrapperModxMinishop2 constructor.
     * @param $modx
     */
    public function __construct(&$modx)
    {
        $this->modx = $modx;
    }

    /**
     * Произольно название интернет-мазагина
     * @return string
     */
    public function getShopName()
    {
        return $this->modx->getOption(self::CONFIG_HG_SHOP_NAME, null, '');
    }

    /**
     * Имя пользователя для доступа к системе ХуткиГрош
     * @return string
     */
    public function getHutkigroshLogin()
    {
        return $this->modx->getOption(self::CONFIG_HG_LOGIN, null, '');
    }

    /**
     * Пароль для доступа к системе ХуткиГрош
     * @return string
     */
    public function getHutkigroshPassword()
    {
        return $this->modx->getOption(self::CONFIG_HG_PASSWORD, null, '');
    }

    /**
     * Включен ли режим песчоницы
     * @return boolean
     */
    public function isSandbox()
    {
        return self::checkOn($this->modx->getOption(self::CONFIG_HG_SANDBOX, null, '0'));
    }

    /**
     * Уникальный идентификатор услуги в ЕРИП
     * @return string
     */
    public function getEripId()
    {
        return $this->modx->getOption(self::CONFIG_HG_ERIP_ID, null, '');
    }

    /**
     * Включена ля оповещение клиента по Email
     * @return boolean
     */
    public function isEmailNotification()
    {
        return self::checkOn($this->modx->getOption(self::CONFIG_HG_EMAIL_NOTIFICATION, null, '0'));
    }

    /**
     * Включена ля оповещение клиента по Sms
     * @return boolean
     */
    public function isSmsNotification()
    {
        return self::checkOn($this->modx->getOption(self::CONFIG_HG_SMS_NOTIFICATION, null, '0'));
    }

    /**
     * Итоговый текст, отображаемый клменту после успешного выставления счета
     * Чаще всего содержит подробную инструкцию по оплате счета в ЕРИП
     * @return string
     */
    public function getCompletionText()
    {
        // TODO: Implement getCompletionText() method.
    }

    /**
     * Какой статус присвоить заказу после успешно выставления счета в ЕРИП (на шлюз Хуткигрош_
     * @return string
     */
    public function getBillStatusPending()
    {
        return $this->modx->getOption(self::CONFIG_HG_BILL_STATUS_PENDING, null, '');
    }

    /**
     * Какой статус присвоить заказу после успешно оплаты счета в ЕРИП (после вызова callback-а шлюзом ХуткиГрош)
     * @return string
     */
    public function getBillStatusPayed()
    {
        return $this->modx->getOption(self::CONFIG_HG_BILL_STATUS_PAYED, null, '');
    }

    /**
     * Какой статус присвоить заказу в случаче ошибки выставления счета в ЕРИП
     * @return string
     */
    public function getBillStatusFailed()
    {
        return $this->modx->getOption(self::CONFIG_HG_BILL_STATUS_FAILED, null, '');
    }

    /**
     * Какой статус присвоить заказу после успешно оплаты счета в ЕРИП (после вызова callback-а шлюзом ХуткиГрош)
     * @return string
     */
    public function getBillStatusCanceled()
    {
        return $this->modx->getOption(self::CONFIG_HG_BILL_STATUS_CANCELED, null, '');
    }

    public function getSuccessResourceId()
    {
        return $this->modx->getOption(self::CONFIG_HG_SUCCESS_RESOURCE_ID, null, '');
    }

    public function getFailedResourceId()
    {
        return $this->modx->getOption(self::CONFIG_HG_FAILED_RESOURCE_ID, null, '');
    }

    private static function checkOn($value)
    {
        return $value = '1';
    }
}