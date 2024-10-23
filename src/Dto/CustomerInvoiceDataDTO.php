<?php

namespace App\Dto;

class CustomerInvoiceDataDTO
{

    /** @var ConsumptionDTO $consumption */
    private ConsumptionDTO $consumption;

    /** @var ContractedPowerDTO $contractedPower */
    private ContractedPowerDTO $contractedPower;

    /** @var string */
    private string $startDate;

    /** @var string */
    private string $endDate;

    /** @var string */
    private string $username;

    public function getConsumption(): ConsumptionDTO
    {
        return $this->consumption;
    }

    public function setConsumption(ConsumptionDTO $consumption): void
    {
        $this->consumption = $consumption;
    }

    public function getContractedPower(): ContractedPowerDTO
    {
        return $this->contractedPower;
    }

    public function setContractedPower(ContractedPowerDTO $contractedPower): void
    {
        $this->contractedPower = $contractedPower;
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