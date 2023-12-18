<?php

namespace App\Command\DownloadDistrict;

use App\Factory\DistrictFactory;
use App\Helper\StringHelper;
use App\Helper\Unit\UnitAreaHelper;
use App\Helper\XPathHelper;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class UpdateGdanskDistrict extends UpdateDistrictFactory implements UpdateDistrictInterface
{
    private const DISTRICTS_BASE_URL = 'https://www.gdansk.pl/';

    public function __toString(): string
    {
        return $this->getCityName();
    }

    protected function getCityName(): string
    {
        return 'Gdańsk';
    }

    protected function getDistrictListUrl(): string
    {
        return self::DISTRICTS_BASE_URL . 'dzielnice';
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function updateDistricts(): void
    {


        $districtsHTML = [];
        foreach ($this->getDistrictsUrl() as $key => $districtUrl) {

            $districtsHTML[$key] = $this->httpService->getResponse(self::DISTRICTS_BASE_URL . $districtUrl);
        }


        foreach ($districtsHTML as $key => $districtHTML) {
            $xpath = XPathHelper::getXPathFromHTML($districtHTML->getContent());

            $districtElements = $xpath->query('//div[@class="opis"]/div');

            $districtName = $districtElements[0]->nodeValue;

            $x = StringHelper::removePrefix($districtElements[1]->nodeValue,'Powierzchnia:');
            $x = explode(' ', trim($x));

            $areaValue = StringHelper::convertStringToFloat($x[0]);

            $districtArea = (float) UnitAreaHelper::convertArea($areaValue, 'km');

            $districtPopulation = StringHelper::extractNumbers($districtElements[2]->nodeValue);


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

        $ulElement = $xpath->query('//ul[@class="lista-dzielnic"]')->item(0);

        $districtsUrl = [];

            $liElements = $xpath->query('.//li[a]', $ulElement);

            foreach ($liElements as $li) {
                $aElement = $xpath->query('./a', $li)->item(0);

                if ($aElement) {
                    $hrefValue = $aElement->getAttribute('href');
                    $districtsUrl[] = $hrefValue;
                }
        }

        return $districtsUrl;
    }
}
