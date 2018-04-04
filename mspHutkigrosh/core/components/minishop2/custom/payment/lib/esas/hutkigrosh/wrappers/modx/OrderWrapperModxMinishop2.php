<?php

namespace esas\hutkigrosh\wrappers\modx;

use esas\hutkigrosh\wrappers\OrderWrapper;
use miniShop2;
use msOrder;

/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 13.03.2018
 * Time: 14:51
 */
class OrderWrapperModxMinishop2 extends OrderWrapper
{
    private $order;
    /** @var miniShop2 $ms2 */
    private $ms;

    /**
     * OrderWrapperModxMinishop2 constructor.
     * @param $order
     */
    public function __construct(msOrder $order)
    {
        $this->order = $order;
        $this->ms = $order->xpdo->getService('miniShop2');
    }


    /**
     * Уникальный номер заказ в рамках CMS
     * @return string
     */
    public function getOrderId()
    {
        return $this->order->get('id');
    }

    /**
     * Полное имя покупателя
     * @return string
     */
    public function getFullName()
    {
        return $this->order->getOne('Address')->get('receiver');
    }

    /**
     * Мобильный номер покупателя для sms-оповещения
     * (если включено администратором)
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->order->getOne('Address')->get('phone');
    }

    /**
     * Email покупателя для email-оповещения
     * (если включено администратором)
     * @return string
     */
    public function getEmail()
    {
        return $this->order->getOne('Address')->get('email');
    }

    /**
     * Физический адрес покупателя
     * @return string
     */
    public function getAddress()
    {
        return $this->order->getOne('Address')->get('region') . ' '
            . $this->order->getOne('Address')->get('city') . ' '
            . $this->order->getOne('Address')->get('street') . ' '
            . $this->order->getOne('Address')->get('building') . ' '
            . $this->order->getOne('Address')->get('room');
    }

    /**
     * Общая сумма товаров в заказе
     * @return string
     */
    public function getAmount()
    {
        return $this->order->get('cost');
    }

    /**
     * Валюта заказа (буквенный код)
     * @return string
     */
    public function getCurrency()
    {
        // TODO: Implement getCurrency() method.
    }

    /**
     * Массив товаров в заказе
     * @return \esas\hutkigrosh\wrappers\OrderProductWrapper[]
     */
    public function getProducts()
    {
        $products = $this->order->getMany('Products');
        foreach ($products as $item) {
            $ret[] = new OrderProductWrapperModxMinishop2($item);
        }
        return $ret;
    }

    /**
     * BillId (идентификатор хуткигрош) успешно выставленного счета
     * @return mixed
     */
    public function getBillId()
    {
        return $this->order->get('properties')['bill_id'];
    }

    /**
     * Текущий статус заказа в CMS
     * @return mixed
     */
    public function getStatus()
    {
        return $this->order->get('status');
    }

    /**
     * Обновляет статус заказа в БД
     * @param $newStatus
     * @return mixed
     */
    public function updateStatus($newStatus)
    {
        $this->ms->changeOrderStatus($this->getOrderId(), $newStatus);
    }

    /**
     * Сохраняет привязку billid к заказу
     * @param $billId
     * @return mixed
     */
    public function saveBillId($billId)
    {
        $this->order->set('properties', array('bill_id' => $billId));
        $this->order->save();
    }
}