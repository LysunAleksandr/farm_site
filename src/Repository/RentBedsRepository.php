<?php

namespace App\Repository;

use App\Entity\RentBeds;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RentBeds|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentBeds|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentBeds[]    findAll()
 * @method RentBeds[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentBedsRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 20;
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentBeds::class);
    }
    public function getCatalogPaginator(int $offset): Paginator
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.renter IS NULL')
            ->orderBy('a.title', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery()
        ;

        return new Paginator($query);
    }

    public function getBedsPaginatorForUser(int $offset, User $user = null): Paginator
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.renter IS NOT NULL')
//            ->setParameter('val', $user)
            ->orderBy('a.title', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery()
        ;

        return new Paginator($query);
    }

    // /**
    //  * @return RentBeds[] Returns an array of RentBeds objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RentBeds
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
