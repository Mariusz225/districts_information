<?php

namespace App\Command\DownloadDistrict;


use App\Entity\City;
use App\Service\Http\HttpService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

abstract class UpdateDistrictFactory
{
    protected array $districtsToUpdate;
    public function __construct(protected HttpService $httpService, protected EntityManagerInterface $entityManager)
    {
    }

    abstract protected function getCityName(): string;

    /**
     * Retrieves an array of district URLs based on the specified XPath query.
     *
     * @return array An associative array where keys are district names and values are district URLs.
     *
     * @throws TransportExceptionInterface If an HTTP transport exception occurs during the request.
     * @throws ServerExceptionInterface If a server exception occurs during the request.
     * @throws RedirectionExceptionInterface If a redirection exception occurs during the request.
     * @throws ClientExceptionInterface If a client exception occurs during the request.
     */
    abstract protected function getDistrictsUrl(): array;

    public function updateDistricts(): void
    {

        $cityRepository = $this->entityManager->getRepository(City::class);

        if (!$city = $cityRepository->findOneBy(['name' => $this->getCityName()])) {
            $city = new City();
            $city->setName($this->getCityName());
        }




        foreach ($this->districtsToUpdate as $districtToUpdate) {
            $city->addDistrict($districtToUpdate);
            $city->addDistrict($districtToUpdate);
            $this->entityManager->persist($districtToUpdate);
        }

        $this->entityManager->persist($city);
        $this->entityManager->flush();
    }
}
