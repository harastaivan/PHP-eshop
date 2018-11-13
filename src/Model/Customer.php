<?php

namespace EShop\Model;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Customer extends ActiveRecord
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
     * Customer constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->generateId();
        $this->name = $name;
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
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
    }

    public static function createDbTable()
    {
        self::execute('
            CREATE TABLE IF NOT EXISTS customer (
              id INTEGER PRIMARY KEY,
              name TEXT,
              loyaltyPoints REAL
            )');
    }
}