<?php

namespace App\Factory;

interface EntityFactoryInterface
{
    public static function getEntity(array $data, $model = null);
}
