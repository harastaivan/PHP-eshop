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
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * Name of table for ActiveRecord
     * @var string
     */
    protected static $table = 'customer';

    /**
     * Customer constructor.
     * @param string $name
     * @param string $username
     * @param string $password
     * @param int $id
     */
    public function __construct($name = null, $username = null, $password = null, $id = null)
    {
        if ($name) {
            if ($id) {
                $this->id = $id;
            } else {
                $this->generateId();
            }
            $this->name = $name;
            $this->username = $username;
            $this->password = $password;
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
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
    }

    /**
     * @throws \Exception
     */
    public static function createDbTable()
    {
        self::execute('
            CREATE TABLE IF NOT EXISTS customer (
              id INTEGER PRIMARY KEY,
              name TEXT,
              loyaltyPoints REAL
            )');
    }

    /**
     * Get example of customers
     * @return Customer[]
     */
    public static function getExamples()
    {
        return [
            new Customer('Honza', 'honza', 'heslo123', 1),
            new Customer('Petr', 'petr', 'passwd', 2),
            new Customer('Karel Novak', 'knovak', 'password', 3)
        ];
    }
}