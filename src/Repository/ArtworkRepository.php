<?php

namespace App\Repository;

use App\Entity\Artwork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Artwork|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artwork|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artwork[]    findAll()
 * @method Artwork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artwork::class);
    }

    // /**
    //  * @return Artwork[] Returns an array of Artwork objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findByCategory($slug)
    {
        return $this->createQueryBuilder('a')
            ->join('a.category', 'c')
            ->where('c.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
        ;
    }

    public function findByCategoryLimited($slug, $nb)
    {
        return $this->createQueryBuilder('a')
            ->join('a.category', 'c')
            ->where('c.slug = :slug')
            ->orderBy('a.id', 'DESC')
            ->setParameter('slug', $slug)
            ->setMaxResults($nb)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllArtworks()
    {
        return $this->createQueryBuilder('a')
            ->getQuery()
        ;
    }
    
    public function findBySlug($slug): ?Artwork
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
