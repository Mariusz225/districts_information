<?php

namespace App\Service;

use App\Repository\DistrictRepository;

class DistrictService
{

    public function __construct(private readonly DistrictRepository $districtRepository)
    {
    }

    public function findFilteredAndSorted(array $filters, string $sortBy = 'name', string $sortOrder = 'asc'): array
    {
        return $this->districtRepository->findFilteredAndSorted($filters, $sortBy, $sortOrder);
    }
}
