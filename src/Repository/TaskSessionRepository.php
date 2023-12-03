<?php

namespace App\Repository;

use App\Entity\TaskSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TaskSession>
 *
 * @method TaskSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskSession[]    findAll()
 * @method TaskSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskSession::class);
    }

//    /**
//     * @return TaskSession[] Returns an array of TaskSession objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TaskSession
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
