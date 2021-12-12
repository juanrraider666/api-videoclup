<?php

namespace App\Repository;

use App\Entity\FilmType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FilmType|null find($id, $lockMode = null, $lockVersion = null)
 * @method FilmType|null findOneBy(array $criteria, array $orderBy = null)
 * @method FilmType[]    findAll()
 * @method FilmType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FilmType::class);
    }

    public function findOneByName($name)
    {
        if (is_string($name)) {
            return $this->createQueryBuilder('f')
                ->andWhere('f.name = :name')
                ->setParameter('name', $name)
                ->addOrderBy()
                ->getQuery()
                ->getSingleResult()
                ;
        }

        return $this->find($name);

    }

    // /**
    //  * @return FilmType[] Returns an array of FilmType objects
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
    public function findOneBySomeField($value): ?FilmType
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
