<?php

namespace EShop\Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Product extends ActiveRecord
{
    /**
     * @var int
     */
    use Id;

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
     * @param string $name
     * @param float $price
     * @param float $vatRate
     */
    public function __construct($name, $price, $vatRate)
    {
        $this->generateId();
        $this->name = $name;
        $this->price = $price;
        $this->vatRate = $vatRate;
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

    /**
     * Returns price with VAT
     *
     * @return float
     */
    public function getPriceVat()
    {
        $priceVat = $this->price + $this->price*$this->vatRate;
        return $priceVat;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint('price', new Assert\GreaterThanOrEqual(0));
        $metadata->addPropertyConstraint('vatRate', new Assert\Range([
            'min' => 0,
            'max' => 1,
        ]));
    }

    public static function createDbTable()
    {
        self::execute('
            CREATE TABLE IF NOT EXISTS product (
              id INTEGER PRIMARY KEY,
              name TEXT,
              price REAL,
              vat_rate REAL
            )');
    }
}