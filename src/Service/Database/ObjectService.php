<?php

namespace App\Service\Database;

use Doctrine\ORM\EntityManagerInterface;

class ObjectService
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function deleteObject($object): void
    {
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }
}
