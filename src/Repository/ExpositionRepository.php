<?php

namespace App\Repository;

use App\Entity\Exposition;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Exposition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exposition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exposition[]    findAll()
 * @method Exposition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpositionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exposition::class);
    }

    // /**
    //  * @return Exposition[] Returns an array of Exposition objects
    //  */
    
    public function findFutureExpositons()
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.date >= :date')
            ->setParameter('date', new DateTime())
            ->orderBy('e.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findArchiveExpositons()
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.date < :date')
            ->setParameter('date', new DateTime())
            ->orderBy('e.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    
    public function findBySlug($slug): ?Exposition
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
