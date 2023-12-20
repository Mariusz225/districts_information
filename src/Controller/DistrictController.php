<?php

namespace App\Controller;

use App\Entity\District;
use App\Factory\DistrictFactory;
use App\Service\Database\ObjectService;
use App\Service\Entity\CityService;
use App\Service\Entity\DistrictService;
use App\Service\Json\JsonSerializationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/district', name: 'api.district.')]
class DistrictController extends AbstractController
{
    public function __construct(
        private readonly DistrictService $districtService,
        private readonly JsonSerializationService $jsonSerializationService
    )
    {
    }

    #[Route('', name: 'list', methods: 'GET')]
    public function getDistricts(Request $request): JsonResponse
    {
        $districts = $this->districtService->findFilteredAndSort(
            $this->districtService->getFiltersFromRequest($request),
            $this->districtService->getSortingFromRequest($request)
        );

        return $this->jsonSerializationService->getSerializedJson($districts, 'district_info');
    }

    #[Route('/{id}', name: 'view', methods: 'GET')]
    public function getDistrict(District $district): JsonResponse
    {
        return $this->jsonSerializationService->getSerializedJson($district, 'district_info');
    }

    #[Route('', name: 'create', methods: 'POST')]
    public function createDistrict(Request $request, EntityManagerInterface $entityManager, CityService $cityService): JsonResponse
    {
        $jsonData = json_decode($request->getContent(), true);

        $district = DistrictFactory::getEntity($jsonData);
        $district->setCity($cityService->getEntityById($jsonData['cityId']));

        $entityManager->persist($district);
        $entityManager->flush();

        return $this->jsonSerializationService->getSerializedJson($district, 'district_info');
    }

    #[Route('/{id}', name: 'update', methods: 'PUT')]
    public function updateDistrict(District $district, Request $request, EntityManagerInterface $entityManager, CityService $cityService): JsonResponse
    {
        $jsonData = json_decode($request->getContent(), true);

        $district = DistrictFactory::getEntity($jsonData, $district);

        $district->setCity($cityService->getEntityById($jsonData['cityId']));

        $entityManager->persist($district);
        $entityManager->flush();

        return $this->jsonSerializationService->getSerializedJson($district, 'district_info');
    }

    #[Route('/{id}', name: 'delete', methods: 'DELETE')]
    public function deleteDistrict(District $district, ObjectService $objectService): Response
    {
        $objectService->deleteObject($district);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
