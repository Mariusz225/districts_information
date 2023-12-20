<?php

namespace App\Repository;

use App\Entity\District;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<District>
 *
 * @method District|null find($id, $lockMode = null, $lockVersion = null)
 * @method District|null findOneBy(array $criteria, array $orderBy = null)
 * @method District[]    findAll()
 * @method District[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistrictRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, District::class);
    }

//    /**
//     * @return District[] Returns an array of District objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?District
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


    public function findFilteredAndSort(array $filters, array $sorting)
    {
        $qb = $this->createQueryBuilder('d');

        if ($filters['name'] ?? null) {
            $qb->andWhere('LOWER(d.name) LIKE LOWER(:name)')
                ->setParameter('name', '%' . $filters['name'] . '%');
        }

        if ($filters['minArea'] ?? null) {
            $qb->andWhere('d.area >= :minArea')
                ->setParameter('minArea', $filters['minArea']);
        }

        if ($filters['maxArea'] ?? null) {
            $qb->andWhere('d.area <= :maxArea')
                ->setParameter('maxArea', $filters['maxArea']);
        }

        if ($filters['minPopulation'] ?? null) {
            $qb->andWhere('d.population >= :minPopulation')
                ->setParameter('minPopulation', $filters['minPopulation']);
        }

        if ($filters['maxPopulation'] ?? null) {
            $qb->andWhere('d.population <= :maxPopulation')
                ->setParameter('maxPopulation', $filters['maxPopulation']);
        }

        $validSortColumns = ['name', 'area', 'population'];
        $sortBy = in_array($sorting['sortBy'], $validSortColumns, true) ? $sorting['sortBy'] : 'name';

        $validSortOrders = ['asc', 'desc'];
        $sortOrder = in_array($sorting['sortOrder'], $validSortOrders, true) ? $sorting['sortOrder'] : 'asc';

        $qb->orderBy('d.' . $sortBy, $sortOrder);

        return $qb->getQuery()->getResult();
    }
}
