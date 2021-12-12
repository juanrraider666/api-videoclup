<?php

namespace App\Repository;

use App\Entity\FilmOwnerRelation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FilmOwnerRelation|null find($id, $lockMode = null, $lockVersion = null)
 * @method FilmOwnerRelation|null findOneBy(array $criteria, array $orderBy = null)
 * @method FilmOwnerRelation[]    findAll()
 * @method FilmOwnerRelation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmOwnerRelationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FilmOwnerRelation::class);
    }

    // /**
    //  * @return FilmOwnerRelation[] Returns an array of FilmOwnerRelation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FilmOwnerRelation
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
