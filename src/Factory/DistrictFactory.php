<?php

namespace App\Factory;

use App\Entity\District;

class DistrictFactory implements EntityFactoryInterface
{

    public static function getEntity(array $data, $model = null): District
    {
        if (!$model) {
            $model = new District();
        }

        $model->setName($data['name'] ?? null);
        $model->setArea($data['area'] ?? null);
        $model->setPopulation($data['population'] ?? null);

        return $model;
    }
}
