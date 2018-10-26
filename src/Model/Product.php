<?php

namespace EShop\Model;

class Product
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * @var float
     */
    private $vatRate;

    /**
     * Product constructor.
     * @param int $id
     * @param string $name
     * @param float $price
     * @param float $vatRate
     */
    public function __construct($id, $name, $price, $vatRate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->vatRate = $vatRate;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getVatRate()
    {
        return $this->vatRate;
    }

    /**
     * @param float $vatRate
     */
    public function setVatRate($vatRate)
    {
        $this->vatRate = $vatRate;
    }

    public function getPriceVat()
    {
        $priceVat = $this->price + $this->price*$this->vatRate;
        return $priceVat;
    }
}