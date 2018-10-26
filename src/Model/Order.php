<?php

namespace EShop\Model;

class Order
{
    /**
     * @var int
     */
    use Id;

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
     * @param \DateTime $created
     * @param \DateTime $ordered
     * @param Customer $customer
     * @param Product[] $items
     */
    public function __construct(\DateTime $created, \DateTime $ordered, Customer $customer, array $items)
    {
        $this->generateId();
        $this->created = $created;
        $this->ordered = $ordered;
        $this->customer = $customer;
        $this->items = $items;
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

    /**
     * Sets ordered date.
     * If order is created by registered customer, it increases its loyalty points.
     */
    public function doOrder()
    {
        $now = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        $this->ordered = $now;

        if ($this->customer instanceof RegisteredCustomer) {
            $totalSum = $this->calculateTotalSum();
            $this->customer->increaseLoyaltyPoints($totalSum);
        }
    }

    /**
     * Calculates total sum of products with VAT
     *
     * @return float
     */
    private function calculateTotalSum()
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += $item->getPriceVat();
        }
        return $sum;
    }
}