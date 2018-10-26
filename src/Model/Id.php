<?php

namespace EShop\Model;


trait Id
{
    /**
     * @var static int
     */
    private static $generatedId = 1;

    /**
     * @var int
     */
    protected $id;

    public function generateId()
    {
        $this->id = static::$generatedId++;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}