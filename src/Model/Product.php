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
    protected $name;

    /**
     * @var float
     */
    protected $price;

    /**
     * @var float
     */
    protected $vatRate;

    /**
     * Product constructor.
     * @param string $name
     * @param float $price
     * @param float $vatRate
     * @param int $id
     */
    public function __construct($name = null, $price = null, $vatRate = null, $id = null)
    {
        if ($name && $price && $vatRate) {
            if ($id) {
                $this->id = $id;
            } else {
                $this->generateId();
            }
            $this->name = $name;
            $this->price = $price;
            $this->vatRate = $vatRate;
        }
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
              vatRate REAL
            )');
    }

    public function getAssocData() {
        $data = [];
        $data['id'] = $this->id;
        $data['name'] = $this->name;
        $data['price'] = $this->price;
        $data['vatRate'] = $this->vatRate;
        return $data;
    }
}