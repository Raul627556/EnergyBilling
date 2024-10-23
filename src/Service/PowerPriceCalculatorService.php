<?php

namespace App\Service;

use App\Dto\CustomerInvoiceDataDTO;
use App\Repository\PowerPricesRepository;
use DateTime;

class PowerPriceCalculatorService
{

    /** @var PowerPricesRepository $powerPricesRepository */
    private PowerPricesRepository $powerPricesRepository;

    /** @var DateGapCheckerService $dateGapChecker */
    private DateGapCheckerService $dateGapChecker;

    /**
     * @param PowerPricesRepository $powerPricesRepository
     * @param DateGapCheckerService $dateGapChecker
     */
    public function __construct(
        PowerPricesRepository $powerPricesRepository,
        DateGapCheckerService $dateGapChecker
    )
    {
        $this->powerPricesRepository = $powerPricesRepository;
        $this->dateGapChecker = $dateGapChecker;
    }


    /**
     * @param CustomerInvoiceDataDTO $customerInvoiceDataDTO
     * @return array
     * @throws \DateMalformedStringException
     */
    public function calculatePrice(CustomerInvoiceDataDTO $customerInvoiceDataDTO)
    {
        $billingStartDay = $customerInvoiceDataDTO->getStartDate();
        $billingEndDay = $customerInvoiceDataDTO->getEndDate();

        $totalCostContractedPower = 0;
        $powerPricesList = $this->powerPricesRepository->findByDateRange($billingStartDay, $billingEndDay);

        $gapData = $this->dateGapChecker->hasGap($billingStartDay, $billingEndDay, $powerPricesList);

        if ($gapData["hasGap"] === true) {
            return [
                "success" => false,
                "errorMessage" => $gapData["messageError"]
            ];
        }

        $startDate = new DateTime($billingStartDay);
        $interval = $startDate->diff(new DateTime($billingEndDay));
        $daysCount = $interval->days + 1;

        foreach ($powerPricesList as $powerPrice) {
            $costContractedPower1 = $customerInvoiceDataDTO->getContractedPower()->getP1() * $powerPrice->getPowerP1() * $daysCount;
            $costContractedPower2 = $customerInvoiceDataDTO->getContractedPower()->getP2() * $powerPrice->getPowerP2() * $daysCount;
            $costContractedPower3 = $customerInvoiceDataDTO->getContractedPower()->getP3() * $powerPrice->getPowerP3() * $daysCount;
            $totalCostContractedPower = $totalCostContractedPower + $costContractedPower1 + $costContractedPower2 + $costContractedPower3;
        }

        return [
            "success" => true,
            "totalCostContractedPower" => $totalCostContractedPower
        ];

    }
}