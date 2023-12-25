<?php

namespace App\Repository;

use App\Entity\EquipProj;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EquipProj>
 *
 * @method EquipProj|null find($id, $lockMode = null, $lockVersion = null)
 * @method EquipProj|null findOneBy(array $criteria, array $orderBy = null)
 * @method EquipProj[]    findAll()
 * @method EquipProj[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EquipProjRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EquipProj::class);
    }

//    /**
//     * @return EquipProj[] Returns an array of EquipProj objects
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

//    public function findOneBySomeField($value): ?EquipProj
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
