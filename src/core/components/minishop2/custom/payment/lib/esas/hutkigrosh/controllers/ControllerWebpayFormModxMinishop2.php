<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 22.03.2018
 * Time: 12:38
 */

namespace esas\hutkigrosh\controllers;


use esas\hutkigrosh\wrappers\ConfigurationWrapperModxMinishop2;

class ControllerWebpayFormModxMinishop2 extends ControllerWebpayForm
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
     * Основная часть URL для возврата с формы webpay (чаще всего current_url)
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->modx->makeUrl($this->modx->resource->get("id"), '', array("msorder" => $_GET['msorder']), 'full', array("xhtml_urls" => false));
    }
}