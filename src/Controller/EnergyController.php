<?php

namespace App\Controller;

use App\Dto\DateRangeDTO;
use App\Dto\EnergyPriceDTO;
use App\Entity\EnergyPrices;
use App\Repository\EnergyPricesRepository;
use DateMalformedStringException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EnergyController extends AbstractController
{

    #[Route('/api/energy/list', name: 'app_energy_index', methods: ['GET'])]
    public function list(
        EnergyPricesRepository $EnergyPricesRepository,
        SerializerInterface   $serializer
    ): JsonResponse
    {
        $EnergyPrices = $EnergyPricesRepository->findAll();

        $jsonEnergyPrices = $serializer->serialize($EnergyPrices, 'json');

        return new JsonResponse($jsonEnergyPrices, 200, [], true);
    }

    #[Route('/api/energy/delete/{id}', name: 'app_energy_delete', methods: ['DELETE'])]
    public function delete(
        int                    $id,
        EnergyPricesRepository  $EnergyPricesRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        $EnergyPrice = $EnergyPricesRepository->find($id);

        if (!$EnergyPrice) {
            return new JsonResponse(['error' => 'Energy price not found'], 404);
        }

        $entityManager->remove($EnergyPrice);
        $entityManager->flush();

        return new JsonResponse(['status' => 'success', 'message' => 'Energy price deleted successfully'], 200);
    }

    #[Route('/api/energy/{id}', name: 'app_energy_get', methods: ['GET'])]
    public function getEnergyPrice(
        int                   $id,
        EnergyPricesRepository $EnergyPricesRepository,
        SerializerInterface   $serializer
    ): JsonResponse
    {
        $EnergyPrice = $EnergyPricesRepository->find($id);

        if (!$EnergyPrice) {
            return new JsonResponse(['error' => 'Energy price not found'], 404);
        }

        $jsonEnergyPrices = $serializer->serialize($EnergyPrice, 'json');

        return new JsonResponse($jsonEnergyPrices, 200, [], true);
    }


    /**
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $em
     * @param EnergyPricesRepository $energyPricesRepository
     * @return JsonResponse
     * @throws DateMalformedStringException
     */
    #[Route('/api/prices/energy', name: 'insert_energy_prices', methods: ['POST'])]
    public function insertEnergyPrices(
        Request                $request,
        SerializerInterface    $serializer,
        ValidatorInterface     $validator,
        EntityManagerInterface $em,
        EnergyPricesRepository $energyPricesRepository
    ): JsonResponse
    {
        $energyPriceDTO = $serializer->deserialize($request->getContent(), EnergyPriceDTO::class, 'json');
        $errors = $validator->validate($energyPriceDTO);
        if (count($errors) > 0) {
            return new JsonResponse(['error' => (string)$errors], 400);
        }

        if ($energyPriceDTO->getId() === 0) {
            $energyPrices = (new EnergyPrices());
        } else {
            $energyPrices = $energyPricesRepository->find($energyPriceDTO->getId());
        }

        $energyPrices
            ->setEnergyP1($energyPriceDTO->getEnergy()->getP1())
            ->setEnergyP2($energyPriceDTO->getEnergy()->getP2())
            ->setEnergyP3($energyPriceDTO->getEnergy()->getP3())
            ->setStartDate(new DateTime($energyPriceDTO->getStartDate()))
            ->setEndDate(new DateTime($energyPriceDTO->getEndDate()))
            ->setUsername($energyPriceDTO->getUsername())
            ->setCreatedAt(new DateTime());


        $em->persist($energyPrices);
        $em->flush();

        return new JsonResponse(['status' => 'success', 'message' => 'Precios de energía guardados correctamente']);
    }



}
