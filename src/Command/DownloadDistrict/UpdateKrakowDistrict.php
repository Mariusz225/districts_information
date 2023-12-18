<?php

namespace App\Command\DownloadDistrict;

use App\Factory\DistrictFactory;
use App\Helper\StringHelper;
use App\Helper\Unit\UnitAreaHelper;
use App\Helper\XPathHelper;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class UpdateKrakowDistrict extends UpdateDistrictFactory implements UpdateDistrictInterface
{


    private const DISTRICTS_BASE_URL = 'https://www.bip.krakow.pl';

    public function __toString(): string
    {
        return $this->getCityName();
    }

    protected function getCityName(): string
    {
        return 'Kraków';
    }

    private function getDistrictListUrl(): string
    {
        return self::DISTRICTS_BASE_URL . '/?bip_id=1&mmi=453';
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[NoReturn] public function updateDistricts(): void
    {


        $districtsHTML = [];
        foreach ($this->getDistrictsUrl() as $key => $districtUrl) {

            $districtsHTML[$key] = $this->httpService->getResponse(self::DISTRICTS_BASE_URL . $districtUrl);
        }


        foreach ($districtsHTML as $key => $districtHTML) {
            $xpath = XPathHelper::getXPathFromHTML($districtHTML->getContent());


            $query = "//h1[starts-with(normalize-space(), '{$key}')]";
            $district = $xpath->query($query)->item(0);
            $districtName = $district->nodeValue;

            $districtName = StringHelper::removePrefix($districtName, $key);
            $districtName = trim(StringHelper::removeTextInsideParentheses($districtName));

            $query = "//p[starts-with(normalize-space(), 'Powierzchnia dzielnicy:')]";
            $districtArea = $xpath->query($query)->item(0);
            $districtArea = StringHelper::removePrefix($districtArea->nodeValue,'Powierzchnia dzielnicy:');
            $districtArea = explode(' ', trim($districtArea));


            $areaValue = StringHelper::convertStringToFloat($districtArea[0]);

            $districtArea = (float) UnitAreaHelper::convertArea($areaValue, $districtArea[1]);



            $query = "//p[starts-with(normalize-space(), 'Liczba mieszkańców')]";
            $districtPopulation = $xpath->query($query)->item(0);

            $districtPopulation = StringHelper::extractNumberFromEnd($districtPopulation->nodeValue);


            $data = [
                'name' => $districtName,
                'area' => $districtArea,
                'population' => $districtPopulation
            ];


            $this->districtsToUpdate[] = DistrictFactory::getEntity($data);

        }

        parent::updateDistricts();
    }

    /**
     * {@inheritdoc}
     */
    protected function getDistrictsUrl(): array
    {
        $html = $this->httpService->getResponse($this->getDistrictListUrl())->getContent();
        $xpath = XPathHelper::getXPathFromHTML($html);

        $liElements = $xpath->query('//li[a[text()="DZIELNICE"]]');

        $districtsUrl = [];

        foreach ($liElements as $li) {
            $ulElements = $xpath->query('.//ul', $li);

            foreach ($ulElements as $ul) {
                $liElements = $xpath->query('.//li[starts-with(normalize-space(), "Dzielnica")]', $ul);
                foreach ($liElements as $li) {
                    $aElements = $xpath->query('.//a', $li)->item(0);

                    $districtsUrl[trim($li->nodeValue)] = $aElements->getAttribute('href');
                }
            }
        }

        return $districtsUrl;
    }
}
