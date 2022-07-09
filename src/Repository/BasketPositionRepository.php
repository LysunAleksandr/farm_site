<?php

namespace App\Repository;

use App\Entity\BasketPosition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method BasketPosition|null find($id, $lockMode = null, $lockVersion = null)
 * @method BasketPosition|null findOneBy(array $criteria, array $orderBy = null)
 * @method BasketPosition[]    findAll()
 * @method BasketPosition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BasketPositionRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 8;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BasketPosition::class);
    }

    public function getBasketPaginator(int $offset, $sessionId): Paginator
    {
        $query = $this->createQueryBuilder('d')
            ->andWhere('d.sessionID = :sessionid')
            ->setParameter('sessionid', $sessionId)
            ->orderBy('d.title', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery()
        ;
        return new Paginator($query);
    }


    // /**
    //  * @return BasketPosition[] Returns an array of BasketPosition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function getBasket( $sessionId ):  ?BasketPosition
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.sessionID = :val')
            ->setParameter('val', $sessionId)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

 /*
    public function findOneBySomeField($value): ?BasketPosition
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
 */
}
