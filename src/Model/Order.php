<?php

namespace EShop\Model;

class Order extends ActiveRecord
{
    /**
     * @var int
     */
    use Id;

    /**
     * @var \DateTime
     */
    protected $created;

    /**
     * @var \DateTime
     */
    protected $ordered;

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * @var Product[]
     */
    protected $items;

    /**
     * Relations between Models
     * @var array
     */
    protected static $relations = [
        'customer' => [self::HAS_ONE, Customer::class],
        'items' => [self::HAS_MANY, Product::class]
    ];

    /**
     * Order constructor.
     * @param \DateTime $created
     * @param Customer $customer
     * @param Product[] $items
     * @param int $id
     */
    public function __construct(\DateTime $created = null, $customer = null, array $items = [], $id = null)
    {

        if ($customer && $created) {
            if ($id) {
                $this->id = $id;
            } else {
                $this->generateId();
            }
            $this->customer = $customer;
            $this->created = $created;
        }
        $this->ordered = null;
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
     * @param int $id
     */
    public function removeItem($id)
    {
        foreach ($this->items as $key => $item) {
            if ($item->getId() === $id) {
                unset($this->items[$key]);
            }
        }
    }

    /**
     * Sets ordered date.
     * If order is created by registered customer, it increases its loyalty points.
     */
    public function doOrder()
    {
        $now = new \DateTime();
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

    public static function createDbTable()
    {
        self::execute('
            CREATE TABLE IF NOT EXISTS `order` (
              id INTEGER PRIMARY KEY,
              created TEXT,
              ordered TEXT,
              customer_id INTEGER,
              FOREIGN KEY(customer_id) REFERENCES customer(id)
            )');

        self::execute('
            CREATE TABLE IF NOT EXISTS order_product (
              order_id INTEGER,
              product_id INTEGER,
              FOREIGN KEY(order_id) REFERENCES `order`(id),
              FOREIGN KEY(product_id) REFERENCES product(id)
            )');
    }
}