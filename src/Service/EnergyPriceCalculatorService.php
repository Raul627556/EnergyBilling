<?php

namespace App\Service;

use App\Dto\CustomerInvoiceDataDTO;
use App\Repository\EnergyPricesRepository;

class EnergyPriceCalculatorService
{

    /** @var EnergyPricesRepository $energyPricesRepository */
    private $energyPricesRepository;

    /** @var DateGapCheckerService $dateGapCheckerService */
    private $dateGapCheckerService;


    /**
     * @param EnergyPricesRepository $energyPricesRepository
     * @param DateGapCheckerService $dateGapCheckerService
     */
    public function __construct(
        EnergyPricesRepository $energyPricesRepository,
        DateGapCheckerService  $dateGapCheckerService
    )
    {
        $this->energyPricesRepository = $energyPricesRepository;
        $this->dateGapCheckerService = $dateGapCheckerService;
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

        $energyPricesList = $this->energyPricesRepository->findByDateRange($billingStartDay, $billingEndDay);

        $gapData = $this->dateGapCheckerService->hasGap($billingStartDay, $billingEndDay, $energyPricesList);

        if ($gapData["hasGap"] === true) {
            return [
                "success" => false,
                "errorMessage" => $gapData["messageError"]
            ];
        }

        $totalPriceEnergyConsumption = 0;


        foreach ($energyPricesList as $energyPrice) {
            $priceEnergyConsumptionP1 = $energyPrice->getEnergyP1() * $customerInvoiceDataDTO->getConsumption()->getP1();
            $priceEnergyConsumptionP2 = $energyPrice->getEnergyP2() * $customerInvoiceDataDTO->getConsumption()->getP2();
            $priceEnergyConsumptionP3 = $energyPrice->getEnergyP3() * $customerInvoiceDataDTO->getConsumption()->getP3();
            $totalPriceEnergyConsumption += $priceEnergyConsumptionP1 + $priceEnergyConsumptionP2 + $priceEnergyConsumptionP3;
        }

        return [
            "success" => true,
            "totalPriceEnergyConsumption" => $totalPriceEnergyConsumption
        ];
    }


}