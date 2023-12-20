<?php

namespace App\Interface;

use Symfony\Component\HttpFoundation\Request;

interface FilteredFieldsInterface
{
    public function getFiltersFromRequest(Request $request): array;
    public function getSortingFromRequest(Request $request): array;
}
