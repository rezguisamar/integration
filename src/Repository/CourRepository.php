<?php

namespace App\Repository;

use App\Entity\Cour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cour>
 *
 * @method Cour|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cour|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cour[]    findAll()
 * @method Cour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cour::class);
    }

//    /**
//     * @return Cour[] Returns an array of Cour objects
//     */
    public function findByNiveau($value): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.niveau = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
       ;
    }
    public function findByCateg($value): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.categorie = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
       ;
    }
    public function search($value): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.titre LIKE :val')
            ->orWhere('c.description LIKE :val')
            ->setParameter('val', '%' . $value . '%')
            ->getQuery()
            ->getResult();
    }

//    public function findOneBySomeField($value): ?Cour
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
