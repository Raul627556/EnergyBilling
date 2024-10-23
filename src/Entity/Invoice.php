<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'Invoices')]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $totalEnergyCost;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $totalPowerCost;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private float $totalInvoice;

    #[ORM\Column(type: 'date')]
    private \DateTime $startDate;

    #[ORM\Column(type: 'date')]
    private \DateTime $endDate;

    #[ORM\Column(type: 'string', length: 255)]
    private string $username;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Invoice
    {
        $this->id = $id;
        return $this;
    }

    public function getTotalEnergyCost(): float
    {
        return $this->totalEnergyCost;
    }

    public function setTotalEnergyCost(float $totalEnergyCost): Invoice
    {
        $this->totalEnergyCost = $totalEnergyCost;
        return $this;
    }

    public function getTotalPowerCost(): float
    {
        return $this->totalPowerCost;
    }

    public function setTotalPowerCost(float $totalPowerCost): Invoice
    {
        $this->totalPowerCost = $totalPowerCost;
        return $this;
    }

    public function getTotalInvoice(): float
    {
        return $this->totalInvoice;
    }

    public function setTotalInvoice(float $totalInvoice): Invoice
    {
        $this->totalInvoice = $totalInvoice;
        return $this;
    }

    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): Invoice
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate): Invoice
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): Invoice
    {
        $this->username = $username;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): Invoice
    {
        $this->createdAt = $createdAt;
        return $this;
    }


}
