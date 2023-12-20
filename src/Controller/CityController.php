<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Service\Json\JsonSerializationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/city', name: 'api.city.')]
class CityController extends AbstractController
{
    public function __construct(private readonly JsonSerializationService $jsonSerializationService)
    {
    }

    #[Route('', name: 'list', methods: 'GET')]
    public function getDistricts(CityRepository $repository): JsonResponse
    {
        $cities = $repository->findAll();
        return $this->jsonSerializationService->getSerializedJson($cities, 'city_info');
    }

}
