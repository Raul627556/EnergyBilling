<?php

namespace App\Repository;


use App\Entity\EnergyPrices;
use DateTime;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EnergyPricesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnergyPrices::class);
    }

    /**
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public function findByDateRange($startDate, $endDate): array
    {
        return $this->createQueryBuilder('energyPrices')
            ->where('energyPrices.startDate <= :endDate')
            ->andWhere('energyPrices.endDate >= :startDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult();
    }



}