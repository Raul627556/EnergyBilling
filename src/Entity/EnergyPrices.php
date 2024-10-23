<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'Energy_Prices')]
class EnergyPrices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private float $energyP1;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private float $energyP2;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private float $energyP3;

    #[ORM\Column(type: 'date')]
    private DateTimeInterface $startDate;

    #[ORM\Column(type: 'date')]
    private DateTimeInterface $endDate;

    #[ORM\Column(type: 'string', length: 255)]
    private string $username;

    #[ORM\Column(type: 'datetime')]
    private DateTimeInterface $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setEnergyP1(float $energyP1): self
    {
        $this->energyP1 = $energyP1;
        return $this;
    }

    public function getEnergyP1(): float
    {
        return $this->energyP1;
    }

    public function setEnergyP2(float $energyP2): self
    {
        $this->energyP2 = $energyP2;
        return $this;
    }

    public function getEnergyP2(): float
    {
        return $this->energyP2;
    }

    public function setEnergyP3(float $energyP3): self
    {
        $this->energyP3 = $energyP3;
        return $this;
    }

    public function getEnergyP3(): float
    {
        return $this->energyP3;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getEndDate(): \DateTimeInterface
    {
        return $this->endDate;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}
