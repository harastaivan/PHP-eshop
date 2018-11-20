<?php

namespace EShop\Test\Model;

use EShop\Model\ActiveRecord;
use EShop\Model\Order;
use EShop\Model\Customer;
use EShop\Model\Product;
use EShop\Model\RegisteredCustomer;
use EShop\Model\UnregisteredCustomer;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /** @var \PDO */
    protected static $pdo;

    public static function setUpBeforeClass()
    {
        self::$pdo = new \PDO('sqlite:test.db');

        ActiveRecord::setDb(self::$pdo);
        self::$pdo->query('DROP TABLE `order`');
        self::$pdo->query('DROP TABLE order_product');
        Order::createDbTable();
    }

    public function testProperties()
    {
        $now = new \DateTime();
        $customer = new Customer('Bedrich', 2);
        $items = [
            new Product('Club Mate', 40, 0.21, 1),
            new Product('Pringles', 55, 0.21, 2),
        ];
        $order = new Order($now, $customer, $items, 1);

        $this->assertEquals(1, $order->getId());
        $this->assertEquals($now, $order->getCreated());
        $this->assertNull($order->getOrdered());
        $this->assertInstanceOf(Customer::class, $order->getCustomer());
        $this->assertInstanceOf(Product::class, $order->getItems()[0]);

        return $order;
    }

    /** @depends testProperties */
    public function testInsert(Order $order)
    {
        $order->insert();

        $statement = self::$pdo->prepare('SELECT id, ordered, customer_id FROM `order` WHERE id=:id');

        $this->assertNotFalse($statement);

        $statement->execute(['id' => 1]);

        $this->assertNotFalse($statement);

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        $this->assertArrayHasKey('id', $result);
        $this->assertEquals(1, $result['id']);

        $this->assertArrayHasKey('ordered', $result);
        $this->assertNull($result['ordered']);

        $this->assertArrayHasKey('customer_id', $result);
        $this->assertEquals(2, $result['customer_id']);
    }

    /** @depends testInsert */
    public function testFind()
    {
        $order = Order::find(1);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertAttributeEquals(1, 'id', $order);
        $this->assertAttributeEquals(null, 'ordered', $order);
        $this->assertAttributeInstanceOf(Customer::class, 'customer', $order);
    }

    /** @depends testProperties */
    public function testAddItem(Order $order)
    {
        $this->assertEquals(2, count($order->getItems()));
        $this->assertArrayHasKey(0, $order->getItems());
        $this->assertArrayHasKey(1, $order->getItems());
        $this->assertArrayNotHasKey(2, $order->getItems());

        $order->addItem(new Product('Coca Cola', 20, 0.21, 3));

        $this->assertEquals(3, count($order->getItems()));
        $this->assertArrayHasKey(0, $order->getItems());
        $this->assertArrayHasKey(1, $order->getItems());
        $this->assertArrayHasKey(2, $order->getItems());

        return $order;
    }

    /** @depends testAddItem */
    public function testRemoveItem(Order $order)
    {
        $this->assertEquals(3, count($order->getItems()));
        $this->assertArrayHasKey(0, $order->getItems());
        $this->assertArrayHasKey(1, $order->getItems());
        $this->assertArrayHasKey(2, $order->getItems());

        $order->removeItem(1);

        $this->assertEquals(2, count($order->getItems()));
        $this->assertArrayNotHasKey(0, $order->getItems());
        $this->assertArrayHasKey(1, $order->getItems());
        $this->assertArrayHasKey(2, $order->getItems());

        return $order;
    }

    /** @depends testRemoveItem */
    public function testUpdate(Order $order)
    {
        $order->setCustomer(new Customer('Ivan', 5));
        $order->update();

        $statement = self::$pdo->prepare('SELECT id, ordered, customer_id FROM `order` WHERE id=:id');

        $this->assertNotFalse($statement);

        $statement->execute(['id' => 1]);

        $this->assertNotFalse($statement);

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        $this->assertArrayHasKey('id', $result);
        $this->assertEquals(1, $result['id']);

        $this->assertArrayHasKey('ordered', $result);
        $this->assertNull($result['ordered']);

        $this->assertArrayHasKey('customer_id', $result);
        $this->assertEquals(5, $result['customer_id']);


        return $order;
    }

    /** @depends testUpdate */
    public function testDoOrder(Order $order)
    {
        $order->doOrder();

        $this->assertNotNull($order->getOrdered());
    }
}
