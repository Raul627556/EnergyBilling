<?php

namespace App\Dto;

class PowerPriceDTO
{

    /** @var int  */
    private int $id;

    private PowerPriceValuesDTO $power;

    /** @var string */
    private string $startDate;

    /** @var string */
    private string $endDate;

    /** @var string */
    private string $username;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): PowerPriceDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getPower(): PowerPriceValuesDTO
    {
        return $this->power;
    }

    public function setPower(PowerPriceValuesDTO $power): PowerPriceDTO
    {
        $this->power = $power;
        return $this;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): PowerPriceDTO
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function setEndDate(string $endDate): PowerPriceDTO
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): PowerPriceDTO
    {
        $this->username = $username;
        return $this;
    }


}