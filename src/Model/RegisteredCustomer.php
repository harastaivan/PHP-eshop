<?php

namespace EShop\Model;


class RegisteredCustomer
{
    const REGISTRATION_LOYALTY_POINTS = 100;
    const LOYALTY_POINTS_COEFFICIENT = 0.5;

    /**
     * @var int
     */
    protected $loyaltyPoints = self::REGISTRATION_LOYALTY_POINTS;

    /**
     * @return int
     */
    public function getLoyaltyPoints()
    {
        return $this->loyaltyPoints;
    }

    /**
     * @param int $loyaltyPoints
     */
    public function setLoyaltyPoints($loyaltyPoints)
    {
        $this->loyaltyPoints = $loyaltyPoints;
    }
}