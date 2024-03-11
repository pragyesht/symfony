<?php

namespace App\Repository;

use App\Entity\Emil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emil>
 *
 * @method Emil|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emil|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emil[]    findAll()
 * @method Emil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emil::class);
    }

//    /**
//     * @return Emil[] Returns an array of Emil objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Emil
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
