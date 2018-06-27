<?php

if (!class_exists('msPaymentInterface')) {
    require_once dirname(dirname(dirname(__FILE__))) . '/model/minishop2/mspaymenthandler.class.php';
}

use esas\hutkigrosh\controllers\ControllerAddBill;
use esas\hutkigrosh\wrappers\ConfigurationWrapperModxMinishop2;
use esas\hutkigrosh\wrappers\OrderWrapperModxMinishop2;

//require_once $GLOBALS["modx"]->getOption('base_path') . 'core/components/minishop2/custom/payment/lib/SimpleAutoloader.php';


class Hutkigrosh extends msPaymentHandler implements msPaymentInterface
{
    public static $configurationWrapper;

    function __construct(xPDOObject $object, $config = array())
    {
        parent::__construct($object, $config);
    }


    /* @inheritdoc} */
    public function send(msOrder $order)
    {
        try {
            if ($order->get('status') > 1) {
                return $this->error('ms2_err_status_wrong');
            }
            $orderWrapper = new OrderWrapperModxMinishop2($order);
            $configurationWrapper = new ConfigurationWrapperModxMinishop2($order->xpdo);
            $controller = new ControllerAddBill($configurationWrapper);
            $context = $order->get('context');
            $params['msorder'] = $orderWrapper->getOrderId();
            $controller->process($orderWrapper);
            $resourceId = $configurationWrapper->getSuccessResourceId();
            $redirectURL = $this->modx->makeUrl($resourceId, $context, $params, 'full', array("xhtml_urls" => false));
            return $this->success('', array('redirect' => $redirectURL));
        } catch (Throwable $e) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,
                'Code[' . $e->getCode() . "]: " . $e->getMessage() . " Trace:" . $e->getTraceAsString());
            return $this->error("Произошла ошибка: " . $e->getMessage() . ". Обратитесь к администратору.");
        }
    }

    /* @inheritdoc} */
    public function receive(msOrder $order, $params = array())
    {
        return true;
    }
}




