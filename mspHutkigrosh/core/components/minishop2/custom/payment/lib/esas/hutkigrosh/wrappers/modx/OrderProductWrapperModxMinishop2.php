<?php
/**
 * Created by PhpStorm.
 * User: nikit
 * Date: 14.03.2018
 * Time: 17:08
 */

namespace esas\hutkigrosh\wrappers\modx;


use esas\hutkigrosh\wrappers\OrderProductWrapper;
use msOrderProduct;

class OrderProductWrapperModxMinishop2 extends OrderProductWrapper
{
    private $product;

    /**
     * OrderProductWrapperModxMinishop2 constructor.
     * @param $product
     */
    public function __construct(msOrderProduct $product)
    {
        $this->product = $product;
    }


    /**
     * Артикул товара
     * @return string
     */
    public function getInvId()
    {
        return $this->product->get('product_id');
    }

    /**
     * Название или краткое описание товара
     * @return string
     */
    public function getName()
    {
        return $this->product->get('name');
    }

    /**
     * Количество товароа в корзине
     * @return mixed
     */
    public function getCount()
    {
        return $this->product->get('count');
    }

    /**
     * Цена за единицу товара
     * @return mixed
     */
    public function getUnitPrice()
    {
        return $this->product->get('price');
    }
}