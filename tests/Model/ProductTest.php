<?php

namespace EShop\Test\Model;

use EShop\Model\ActiveRecord;
use EShop\Model\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /** @var \PDO */
    protected static $pdo;

    public static function setUpBeforeClass()
    {
        self::$pdo = new \PDO('sqlite:test.db');

        ActiveRecord::setDb(self::$pdo);
        self::$pdo->query('DROP TABLE product');
        Product::createDbTable();
    }

    public function testProperties()
    {
        $product = new Product('Club Mate', 40, 0.21, 3);

        $this->assertEquals(3, $product->getId());
        $this->assertEquals('Club Mate', $product->getName());
        $this->assertEquals(40, $product->getPrice());
        $this->assertEquals(0.21, $product->getVatRate());
        $this->assertEquals(40 * (1 + 0.21), $product->getPriceVat());

        $product->setName('Club Mate');
        $this->assertEquals('Club Mate', $product->getName());

        $product->setPrice(42);
        $this->assertEquals(42, $product->getPrice());
        $this->assertEquals(42 * (1 + 0.21), $product->getPriceVat());

        return $product;
    }

    /** @depends testProperties */
    public function testInsert(Product $product)
    {
        $product->insert();

        $statement = self::$pdo->prepare('SELECT id, name, price, vatRate FROM product WHERE id=:id');

        $this->assertNotFalse($statement);

        $statement->execute(['id' => 3]);

        $this->assertNotFalse($statement);

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        $this->assertArrayHasKey('id', $result);
        $this->assertEquals(3, $result['id']);

        $this->assertArrayHasKey('name', $result);
        $this->assertEquals('Club Mate', $result['name']);

        $this->assertArrayHasKey('price', $result);
        $this->assertEquals(42, $result['price']);

        $this->assertArrayHasKey('vatRate', $result);
        $this->assertEquals(0.21, $result['vatRate']);
    }

    /** @depends testInsert */
    public function testFind()
    {
        $product = Product::find(3);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertAttributeEquals(3, 'id', $product);
        $this->assertAttributeEquals('Club Mate', 'name', $product);
        $this->assertAttributeEquals(42, 'price', $product);
        $this->assertAttributeEquals(0.21, 'vatRate', $product);
    }
}
