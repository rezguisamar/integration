<?php

namespace App\Repository;

use App\Entity\Charity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Charity>
 *
 * @method Charity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Charity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Charity[]    findAll()
 * @method Charity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Charity::class);
    }
    public function findAll(): array
    {
        $charities = parent::findAll();

        // Debug output
        dump($charities);

        return $charities;
    }
    //    /**
    //     * @return Charity[] Returns an array of Charity objects
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

    //    public function findOneBySomeField($value): ?Charity
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
