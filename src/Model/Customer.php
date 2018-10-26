<?php

namespace EShop\Model;

class Customer
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
}