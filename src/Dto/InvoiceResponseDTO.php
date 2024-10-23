<?php

namespace App\Dto;

class InvoiceResponseDTO
{

    /** @var float  */

    private float $totalEnergyCost;

    /** @var float  */
    private float $totalPowerCost;

    /** @var float  */
    private float $totalInvoice;

    /** @var int  */
    private int $invoiceId;


    public function getTotalEnergyCost(): float
    {
        return $this->totalEnergyCost;
    }

    public function setTotalEnergyCost(float $totalEnergyCost): InvoiceResponseDTO
    {
        $this->totalEnergyCost = round($totalEnergyCost, 2);
        return $this;
    }

    public function getTotalPowerCost(): float
    {
        return $this->totalPowerCost;
    }

    public function setTotalPowerCost(float $totalPowerCost): InvoiceResponseDTO
    {
        $this->totalPowerCost = round($totalPowerCost, 2);
        return $this;
    }

    public function getTotalInvoice(): float
    {
        return $this->totalInvoice;
    }

    public function setTotalInvoice(float $totalInvoice): InvoiceResponseDTO
    {
        $this->totalInvoice = round($totalInvoice, 2);
        return $this;
    }

    public function getInvoiceId(): int
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(int $invoiceId): InvoiceResponseDTO
    {
        $this->invoiceId = $invoiceId;
        return $this;
    }

}