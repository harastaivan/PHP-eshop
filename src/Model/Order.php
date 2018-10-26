<?php

namespace EShop\Model;

class Order
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $ordered;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var Product[]
     */
    private $items;

    /**
     * Order constructor.
     * @param int $id
     * @param \DateTime $created
     * @param \DateTime $ordered
     * @param Customer $customer
     * @param Product[] $items
     */
    public function __construct($id, \DateTime $created, \DateTime $ordered, Customer $customer, array $items)
    {
        $this->id = $id;
        $this->created = $created;
        $this->ordered = $ordered;
        $this->customer = $customer;
        $this->items = $items;
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
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getOrdered()
    {
        return $this->ordered;
    }

    /**
     * @param \DateTime $ordered
     */
    public function setOrdered($ordered)
    {
        $this->ordered = $ordered;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return Product[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Product[] $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @param Product $item
     */
    public function addItem(Product $item)
    {
        $this->items[] = $item;
    }

    /**
     * @param Product $item
     */
    public function removeItem(Product $item)
    {
        if(($key = array_search($item, $this->items, true)) !== false) {
            unset($this->items[$key]);
        }
    }


}