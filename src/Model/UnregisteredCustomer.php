<?php

namespace EShop\Model;

use EShop\Logger;


class UnregisteredCustomer extends Customer
{
    public function register()
    {
        $logger = new Logger('name');
        $logger->logInfo('Customer with id ' . $this->id . ' is registered');
        return new RegisteredCustomer($this->name, $this->id);
    }
}