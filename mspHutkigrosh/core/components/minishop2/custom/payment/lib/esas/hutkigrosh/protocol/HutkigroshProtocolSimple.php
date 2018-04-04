<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 13.03.2018
 * Time: 15:08
 */

namespace esas\hutkigrosh\protocol;


use esas\hutkigrosh\wrappers\ConfigurationWrapper;
use esas\hutkigrosh\wrappers\OrderWrapper;
use Exception;

class HutkigroshProtocolSimple
{
    /**
     * @param ConfigurationWrapper $configurationWrapper
     * @param OrderWrapper $orderWrapper
     * @return BillNewRs|LoginRs
     * @throws Exception
     */
    public static function addBill(ConfigurationWrapper &$configurationWrapper, OrderWrapper &$orderWrapper)
    {
        if (empty($configurationWrapper) || empty($orderWrapper)) {
            throw new Exception("Incorrect method call! configurationWrapper or orderWrapper is null");
        }
        $hg = new HutkigroshProtocol($configurationWrapper->isSandbox());
        $resp = $hg->apiLogIn(new LoginRq($configurationWrapper->getHutkigroshLogin(), $configurationWrapper->getHutkigroshPassword()));
        if ($resp->hasError()) {
            $hg->apiLogOut();
            throw new Exception($resp->getResponseMessage(), $resp->getResponseCode());
        }
        $billNewRq = new BillNewRq();
        $billNewRq->setEripId($configurationWrapper->getEripId());
        $billNewRq->setInvId($orderWrapper->getOrderId());
        $billNewRq->setFullName($orderWrapper->getFullName());
        $billNewRq->setMobilePhone($orderWrapper->getMobilePhone());
        $billNewRq->setEmail($orderWrapper->getEmail());
        $billNewRq->setFullAddress($orderWrapper->getAddress());
        $billNewRq->setAmount($orderWrapper->getAmount());
        $billNewRq->setCurrency($orderWrapper->getCurrency());
        $billNewRq->setNotifyByEMail($configurationWrapper->isEmailNotification());
        $billNewRq->setNotifyByMobilePhone($configurationWrapper->isSmsNotification());
        foreach ($orderWrapper->getProducts() as $cartProduct) {
            $product = new BillProduct();
            $product->setName($cartProduct->getName());
            $product->setInvId($cartProduct->getInvId());
            $product->setCount($cartProduct->getCount());
            $product->setUnitPrice($cartProduct->getUnitPrice());
            $billNewRq->addProduct($product);
            unset($product); //??
        }
        $resp = $hg->apiBillNew($billNewRq);
        $hg->apiLogOut();
        if ($resp->hasError()) {
            throw new Exception($resp->getResponseMessage(), $resp->getResponseCode());
        }
        return $resp;
    }

}