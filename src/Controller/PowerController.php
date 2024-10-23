<?php

namespace App\Controller;

use App\Dto\EnergyPriceDTO;
use App\Dto\PowerPriceDTO;
use App\Entity\PowerPrices;
use App\Repository\PowerPricesRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PowerController extends AbstractController
{

    #[Route('/api/power/list', name: 'app_power_index', methods: ['GET'])]
    public function list(
        PowerPricesRepository $powerPricesRepository,
        SerializerInterface   $serializer
    ): JsonResponse
    {
        $powerPrices = $powerPricesRepository->findAll();

        $jsonPowerPrices = $serializer->serialize($powerPrices, 'json');

        return new JsonResponse($jsonPowerPrices, 200, [], true);
    }

    #[Route('/api/power/delete/{id}', name: 'app_power_delete', methods: ['DELETE'])]
    public function delete(
        int                    $id,
        PowerPricesRepository  $powerPricesRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        $powerPrice = $powerPricesRepository->find($id);

        if (!$powerPrice) {
            return new JsonResponse(['error' => 'Power price not found'], 404);
        }

        $entityManager->remove($powerPrice);
        $entityManager->flush();

        return new JsonResponse(['status' => 'success', 'message' => 'Power price deleted successfully'], 200);
    }

    #[Route('/api/power/{id}', name: 'app_power_get', methods: ['GET'])]
    public function getPowerPrice(
        int                   $id,
        PowerPricesRepository $powerPricesRepository,
        SerializerInterface   $serializer
    ): JsonResponse
    {
        $powerPrice = $powerPricesRepository->find($id);

        if (!$powerPrice) {
            return new JsonResponse(['error' => 'Power price not found'], 404);
        }

        $jsonPowerPrices = $serializer->serialize($powerPrice, 'json');

        return new JsonResponse($jsonPowerPrices, 200, [], true);
    }



    /**
     * @throws \DateMalformedStringException
     */
    #[Route('/api/prices/power', name: 'insert_power_prices', methods: ['POST'])]
    public function insertPowerPrices(
        Request                $request,
        SerializerInterface    $serializer,
        ValidatorInterface     $validator,
        EntityManagerInterface $em,
        PowerPricesRepository  $powerPricesRepository

    ): Response
    {
        $powerPriceDTO = $serializer->deserialize($request->getContent(), PowerPriceDTO::class, 'json');

        $errors = $validator->validate($powerPriceDTO);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string)$errors], 400);
        }

        if ($powerPriceDTO->getId() === 0) {
            $powerPrices = (new PowerPrices());
        } else {
            $powerPrices = $powerPricesRepository->find($powerPriceDTO->getId());
        }

        $powerPrices
            ->setPowerP1($powerPriceDTO->getPower()->getP1())
            ->setPowerP2($powerPriceDTO->getPower()->getP2())
            ->setPowerP3($powerPriceDTO->getPower()->getP3())
            ->setStartDate(new DateTime($powerPriceDTO->getStartDate()))
            ->setEndDate(new DateTime($powerPriceDTO->getEndDate()))
            ->setUsername($powerPriceDTO->getUsername())
            ->setCreatedAt(new DateTime());

        $em->persist($powerPrices);
        $em->flush();


        return new JsonResponse(['status' => 'success', 'message' => 'Precios de la potencia guardados correctamente']);

    }
}
