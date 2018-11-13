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
     * @param int $id
     */
    public function __construct($name = null, $id = null)
    {
        if ($name) {
            if ($id) {
                $this->id = $id;
            } else {
                $this->generateId();
            }
            $this->name = $name;
        }
    }

    /**
     * @return null|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null|string $id
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