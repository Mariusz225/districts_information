<?php

namespace App\Service\Entity;

use App\Interface\FilteredFieldsInterface;
use App\Repository\DistrictRepository;
use Symfony\Component\HttpFoundation\Request;

class DistrictService implements FilteredFieldsInterface
{

    public function __construct(private readonly DistrictRepository $districtRepository)
    {
    }

    public function findFilteredAndSort(array $filters = [], array $sorting = []): array
    {
        return $this->districtRepository->findFilteredAndSort($filters, $sorting);
    }

    public function getFiltersFromRequest(Request $request): array
    {
        return [
            'name' => $request->query->get('name'),
            'minArea' => $request->query->get('minArea'),
            'maxArea' => $request->query->get('maxArea'),
            'minPopulation' => $request->query->get('minPopulation'),
            'maxPopulation' => $request->query->get('maxPopulation'),
        ];
    }

    public function getSortingFromRequest(Request $request): array
    {
        return [
            'sortBy' => $request->query->get('sortBy', 'name'),
            'sortOrder' => $request->query->get('sortOrder', 'asc')
        ];
    }
}
