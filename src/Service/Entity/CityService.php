<?php

namespace App\Service\Entity;

use App\Entity\City;
use App\Repository\CityRepository;

class CityService
{
    public function __construct(private readonly CityRepository $repository)
    {
    }

    public function getEntityById($id): ?City
    {
        return $this->repository->find($id);

    }
}
