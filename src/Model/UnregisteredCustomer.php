<?php

namespace EShop\Model;


class UnregisteredCustomer extends Customer
{
    public function register()
    {
        return new RegisteredCustomer();
    }
}