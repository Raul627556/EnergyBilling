<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'Power_Prices')]
class PowerPrices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private float $powerP1;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private float $powerP2;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    private float $powerP3;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $startDate;

    #[ORM\Column(type: 'date')]
    private \DateTimeInterface $endDate;

    #[ORM\Column(type: 'string', length: 255)]
    private string $username;

    #[ORM\Column(type: 'datetime', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private \DateTimeInterface $createdAt;


    public function getId(): int
    {
        return $this->id;
    }

    public function getPowerP1(): float
    {
        return $this->powerP1;
    }

    public function setPowerP1(float $powerP1): self
    {
        $this->powerP1 = $powerP1;
        return $this;
    }

    public function getPowerP2(): float
    {
        return $this->powerP2;
    }

    public function setPowerP2(float $powerP2): self
    {
        $this->powerP2 = $powerP2;
        return $this;
    }

    public function getPowerP3(): float
    {
        return $this->powerP3;
    }

    public function setPowerP3(float $powerP3): self
    {
        $this->powerP3 = $powerP3;
        return $this;
    }

    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): \DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
