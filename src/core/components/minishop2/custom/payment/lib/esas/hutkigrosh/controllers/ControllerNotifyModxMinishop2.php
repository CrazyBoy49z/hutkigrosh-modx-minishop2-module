<?php

namespace esas\hutkigrosh\controllers;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 11:55
 */
use esas\hutkigrosh\wrappers\ConfigurationWrapperModxMinishop2;
use esas\hutkigrosh\wrappers\OrderWrapperModxMinishop2;

class ControllerNotifyModxMinishop2 extends ControllerNotify
{
    private $modx;

    /**
     * ControllerNotifyModxMinishop2 constructor.
     */
    public function __construct(ConfigurationWrapperModxMinishop2 $configurationWrapper)
    {
        parent::__construct($configurationWrapper);
        $this->modx = $configurationWrapper->modx;
    }


    /**
     * По локальному идентификатору заказа возвращает wrapper
     * @param $orderId
     * @return \esas\hutkigrosh\wrappers\OrderWrapper
     */
    public function getOrderWrapper($orderId)
    {
        $order = $this->configurationWrapper->modx->getObject('msOrder', $orderId);
        return empty($order) ? null : new OrderWrapperModxMinishop2($order);
    }
}