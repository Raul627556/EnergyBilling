<?php

namespace App\Dto;

class PowerPriceValuesDTO
{

    /** @var float */
    private float $p1;

    /** @var float */
    private float $p2;

    /** @var float */
    private float $p3;

    public function __construct(float $p1, float $p2, float $p3)
    {
        $this->p1 = $p1;
        $this->p2 = $p2;
        $this->p3 = $p3;
    }

    public function getP1(): float
    {
        return $this->p1;
    }

    public function setP1(float $p1): void
    {
        $this->p1 = $p1;
    }

    public function getP2(): float
    {
        return $this->p2;
    }

    public function setP2(float $p2): void
    {
        $this->p2 = $p2;
    }

    public function getP3(): float
    {
        return $this->p3;
    }

    public function setP3(float $p3): void
    {
        $this->p3 = $p3;
    }

}