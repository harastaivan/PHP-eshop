<?php

namespace EShop\Model;


class RegisteredCustomer
{
    const REGISTRATION_LOYALTY_POINTS = 100;
    const LOYALTY_POINTS_COEFFICIENT = 0.5;

    /**
     * @var float
     */
    protected $loyaltyPoints = self::REGISTRATION_LOYALTY_POINTS;

    /**
     * @return float
     */
    public function getLoyaltyPoints()
    {
        return $this->loyaltyPoints;
    }

    /**
     * @param float $loyaltyPoints
     */
    public function setLoyaltyPoints($loyaltyPoints)
    {
        $this->loyaltyPoints = $loyaltyPoints;
    }

    /**
     * Increases loyalty points based on price of order.
     *
     * @param $price
     */
    public function increaseLoyaltyPoints($price)
    {
        $points = $this->calculateLoyaltyPointsIncrease($price);
        $this->loyaltyPoints += $points;
    }

    /**
     * Calculates increase of loyalty points based on price and coefficient.
     *
     * @param $price
     * @return float
     */
    private function calculateLoyaltyPointsIncrease($price)
    {
        return $price * self::LOYALTY_POINTS_COEFFICIENT;
    }
}