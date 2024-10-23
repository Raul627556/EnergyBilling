<?php
namespace App\Dto;

class EnergyPriceDTO
{

    /** @var int  */
    private int $id;

    /** @var EnergyPriceValuesDTO */
    private EnergyPriceValuesDTO $energy;

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

    public function setId(int $id): EnergyPriceDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getEnergy(): EnergyPriceValuesDTO
    {
        return $this->energy;
    }

    public function setEnergy(EnergyPriceValuesDTO $energy): void
    {
        $this->energy = $energy;
    }


    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): string
    {
        return $this->endDate;
    }

    public function setEndDate(string $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

}