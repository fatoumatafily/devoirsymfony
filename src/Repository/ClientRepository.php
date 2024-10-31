<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function searchBySurnameOrTel(?string $term, int $page = 1, int $limit = 10)
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.surname LIKE :term')
            ->orWhere('c.tel LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->orderBy('c.createAt', 'DESC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);
        return $qb->getQuery()->getResult();
    }

    public function countSearchResults(?string $term)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.surname LIKE :term')
            ->orWhere('c.tel LIKE :term')
            ->setParameter('term', '%' . $term . '%');

        return $qb->getQuery()->getSingleScalarResult();
    }

    //    /**
    //     * @return Client[] Returns an array of Client objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Client
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
