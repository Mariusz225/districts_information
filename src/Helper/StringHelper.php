<?php

namespace App\Helper;

class StringHelper
{
    public static function removePrefix($originalString, $prefix)
    {
        if (str_starts_with($originalString, $prefix)) {
            return substr($originalString, strlen($prefix));
        } else {
            return $originalString;
        }
    }

    public static function removeTextInsideParentheses($originalString)
    {
        $start = strpos($originalString, '(');

        $end = strpos($originalString, ')', $start);

        if ($start !== false && $end !== false) {
            $originalString = substr_replace($originalString, '', $start, $end - $start + 1);
        }

        return $originalString;
    }

    public static function extractNumberFromEnd($string): ?int
    {
        $matches = array();
        if (preg_match('#(\d+)$#', $string, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public static function convertStringToFloat($string): float
    {
        return floatval(str_replace(',', '.', $string));
    }

    public static function extractNumbers($inputString): int
    {
        preg_match_all('/\d+/', $inputString, $matches);

        $result = implode('', $matches[0]);

        return (int)$result;
    }
}
