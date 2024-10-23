<?php

namespace App\Service;

use DateMalformedStringException;
use DateTime;

class DateGapCheckerService
{

    /**
     * @param $startDate
     * @param $endDate
     * @param $listPricesDates
     * @return array|false[]
     * @throws DateMalformedStringException
     */
    public function hasGap($startDate, $endDate, $listPricesDates): array
    {
        $currentDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);

        foreach ($listPricesDates as $priceDates) {
            $resultStartDate = $priceDates->getStartDate();
            $resultEndDate = $priceDates->getEndDate();

            if ($resultStartDate > $currentDate) {
                return [
                    "hasGap" => true,
                    "messageError" => 'Missing energy prices for the period from ' . $currentDate->format('Y-m-d') . ' to ' . $resultStartDate->modify('-1 day')->format('Y-m-d')
                ];
            }

            $currentDate = $resultEndDate->modify('+1 day');
        }

        if ($currentDate <= $endDate) {
            return [
                "hasGap" => true,
                "messageError" => 'Missing energy prices for the period from ' . $currentDate->format('Y-m-d') . ' to ' . $endDate->format('Y-m-d')
            ];
        }

        return ["hasGap" => false];
    }


}