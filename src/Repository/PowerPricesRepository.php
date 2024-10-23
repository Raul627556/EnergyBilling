<?php

namespace App\Repository;

use App\Entity\PowerPrices;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PowerPricesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PowerPrices::class);
    }

    /**
     * @param $startDate
     * @param $endDate
     * @return array
     */
    public function findByDateRange($startDate, $endDate): array
    {
        return $this->createQueryBuilder('powerPrices')
            ->where('powerPrices.startDate <= :endDate')
            ->andWhere('powerPrices.endDate >= :startDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->getQuery()
            ->getResult();
    }

}