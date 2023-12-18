<?php

namespace App\Helper\Unit;

class UnitAreaHelper
{
    private const CONVERSION_FACTORS = [
        'km' => ['km' => 1, 'ha' => 100],
        'ha' => ['km' => 0.01, 'ha' => 1]
    ];
    public static function convertArea($value, $fromUnit = 'ha', $toUnit = 'km'): float|int|null
    {
        return $value * self::CONVERSION_FACTORS[$fromUnit][$toUnit] ?? null;
    }
}
