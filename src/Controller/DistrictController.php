<?php

namespace App\Controller;

use App\Entity\District;
use App\Factory\DistrictFactory;
use App\Service\DistrictService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/district', name: 'api.district.')]
class DistrictController extends AbstractController
{
    public function __construct(private readonly DistrictService $districtService)
    {
    }

    #[Route('', name: 'list', methods: 'GET')]
    public function getDistricts(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $filters = [
            'name' => $request->query->get('name'),
            'minArea' => $request->query->get('minArea'),
            'maxArea' => $request->query->get('maxArea'),
            'minPopulation' => $request->query->get('minPopulation'),
            'maxPopulation' => $request->query->get('maxPopulation'),
        ];

        $sortBy = $request->query->get('sortBy', 'name');
        $sortOrder = $request->query->get('sortOrder', 'asc');

        $districts = $this->districtService->findFilteredAndSorted($filters, $sortBy, $sortOrder);

        $data = $serializer->serialize($districts, JsonEncoder::FORMAT, ['groups' => 'district_info']);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'view', methods: 'GET')]
    public function getDistrict(District $district, SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->serialize($district, JsonEncoder::FORMAT, ['groups' => 'district_info']);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/', name: 'create', methods: 'POST')]
    public function createDistrict(SerializerInterface $serializer): JsonResponse
    {
        //TODO POST Method
    }

    #[Route('/{id}', name: 'update', methods: 'PUT')]
    public function updateDistrict(District $district, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): JsonResponse
    {
        $jsonData = json_decode($request->getContent(), true);

        $district = DistrictFactory::getEntity($jsonData, $district);

        $entityManager->persist($district);
        $entityManager->flush();

        $data = $serializer->serialize($district, JsonEncoder::FORMAT, ['groups' => 'district_info']);

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/', name: 'delete', methods: 'DELETE')]
    public function deleteDistrict(District $district, SerializerInterface $serializer): Response
    {
        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
