<?php

namespace App\Controller;

use App\Dto\CustomerInvoiceDataDTO;
use App\Dto\InvoiceResponseDTO;
use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use App\Service\EnergyPriceCalculatorService;
use App\Service\PowerPriceCalculatorService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BillingController extends AbstractController
{

    #[\Symfony\Component\Routing\Annotation\Route('/api/billing/list', name: 'app_billing_index', methods: ['GET'])]
    public function list(
        InvoiceRepository $InvoiceRepository,
        SerializerInterface   $serializer
    ): JsonResponse
    {
        $Invoice = $InvoiceRepository->findAll();

        $jsonInvoice = $serializer->serialize($Invoice, 'json');

        return new JsonResponse($jsonInvoice, 200, [], true);
    }

    #[Route('/api/billing/delete/{id}', name: 'app_billing_delete', methods: ['DELETE'])]
    public function delete(
        int                    $id,
        InvoiceRepository  $InvoiceRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        $EnergyPrice = $InvoiceRepository->find($id);

        if (!$EnergyPrice) {
            return new JsonResponse(['error' => 'Invoice not found'], 404);
        }

        $entityManager->remove($EnergyPrice);
        $entityManager->flush();

        return new JsonResponse(['status' => 'success', 'message' => 'Invoice deleted successfully'], 200);
    }

    #[Route('/api/billing/{id}', name: 'app_billing_get', methods: ['GET'])]
    public function getEnergyPrice(
        int                   $id,
        InvoiceRepository $InvoiceRepository,
        SerializerInterface   $serializer
    ): JsonResponse
    {
        $EnergyPrice = $InvoiceRepository->find($id);

        if (!$EnergyPrice) {
            return new JsonResponse(['error' => 'Billing not found'], 404);
        }

        $jsonInvoice = $serializer->serialize($EnergyPrice, 'json');

        return new JsonResponse($jsonInvoice, 200, [], true);
    }


    /**
     * @throws \DateMalformedStringException
     */
    #[\Symfony\Component\Routing\Annotation\Route('/api/generatebill', name: 'generate_billing', methods: ['POST'])]
    public function insertInvoice(
        Request                      $request,
        SerializerInterface          $serializer,
        ValidatorInterface           $validator,
        EntityManagerInterface       $em,
        EnergyPriceCalculatorService $energyPriceCalculatorService,
        PowerPriceCalculatorService  $powerPriceCalculatorService
    ): JsonResponse
    {

        /** @var CustomerInvoiceDataDTO $customerInvoiceDataDTO */
        $customerInvoiceDataDTO = $serializer->deserialize($request->getContent(), CustomerInvoiceDataDTO::class, 'json');

        $errors = $validator->validate($customerInvoiceDataDTO);
        if (count($errors) > 0) {
            return new JsonResponse(['error' => (string)$errors], 400);
        }
        $billingStartDay = $customerInvoiceDataDTO->getStartDate();
        $billingEndDay = $customerInvoiceDataDTO->getEndDate();

        $resultEnergyPrice = $energyPriceCalculatorService->calculatePrice($customerInvoiceDataDTO);

        if ($resultEnergyPrice["success"] === false) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $resultEnergyPrice['errorMessage']
            ], 400);
        }

        $totalPriceEnergyConsumption = $resultEnergyPrice["totalPriceEnergyConsumption"];

        $resultPowerPrice = $powerPriceCalculatorService->calculatePrice($customerInvoiceDataDTO);
        if ($resultPowerPrice["success"] === false) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $resultPowerPrice['errorMessage']
            ], 400);
        }
        $totalCostContractedPower = $resultPowerPrice["totalCostContractedPower"];


        $totalInvoice = $totalPriceEnergyConsumption + $totalCostContractedPower;

        $invoice = (new Invoice())
            ->setTotalEnergyCost($totalPriceEnergyConsumption)
            ->setTotalPowerCost($totalCostContractedPower)
            ->setTotalInvoice($totalInvoice)
            ->setUsername($customerInvoiceDataDTO->getUsername())
            ->setStartDate(new DateTime($billingStartDay))
            ->setEndDate(new DateTime($billingEndDay))
            ->setCreatedAt(new DateTime());

        $em->persist($invoice);
        $em->flush();

        $invoiceResponseDTO = (new InvoiceResponseDTO())
            ->setInvoiceId($invoice->getId())
            ->setTotalInvoice($totalInvoice)
            ->setTotalPowerCost($totalCostContractedPower)
            ->setTotalEnergyCost($totalPriceEnergyConsumption);

        $jsonContent = $serializer->serialize($invoiceResponseDTO, 'json');

        return new JsonResponse($jsonContent, 200, [], true);
    }


}
