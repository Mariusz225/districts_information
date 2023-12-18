<?php

namespace App\Helper;

use DOMDocument;
use DOMXPath;

class XPathHelper
{

    public static function getXPathFromUrl($url): DOMXPath
    {
        $dom = new DOMDocument;

        libxml_use_internal_errors(true);
        $dom->loadHTML(file_get_contents($url));
        libxml_clear_errors();

        return new DOMXPath($dom);
    }

    public static function getXPathFromHTML(string $html): DOMXPath
    {
        $dom = new DOMDocument;

        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();

        return new DOMXPath($dom);
    }
}
