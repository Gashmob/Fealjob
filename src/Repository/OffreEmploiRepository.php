<?php

namespace App\Repository;

use App\Entity\OffreEmploi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OffreEmploi|null find($id, $lockMode = null, $lockVersion = null)
 * @method OffreEmploi|null findOneBy(array $criteria, array $orderBy = null)
 * @method OffreEmploi[]    findAll()
 * @method OffreEmploi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OffreEmploiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OffreEmploi::class);
    }

    /**
     * @param float|string $salaire
     * @param float|string $heures
     * @param bool|string $loge
     * @param bool|string $deplacement
     * @param bool|string $teletravail
     * @return OffreEmploi[]
     */
    public function findBySalaireHeuresLogeDeplacementTeletravail($salaire, $heures, $loge, $deplacement, $teletravail): array
    {
        $query = $this->createQueryBuilder('o');

        if ($salaire != 'none') {
            $query->andWhere('o.salaire >= :salaire')
                ->setParameter('salaire', $salaire);
        }
        if ($heures != 'none') {
            $query->andWhere('o.heures <= :heures')
                ->setParameter('heures', $heures);
        }
        if ($loge != 'none') {
            $query->andWhere('o.loge = :loge')
                ->setParameter('loge', $loge);
        }
        if ($deplacement != 'none') {
            $query->andWhere('o.deplacement = :deplacement')
                ->setParameter('deplacement', $deplacement);
        }
        if ($teletravail != 'none') {
            $query->andWhere('o.teletravail = :teletravail')
                ->setParameter('teletravail', $teletravail);
        }

        return $query->getQuery()->getResult();
    }

    // /**
    //  * @return OffreEmploi[] Returns an array of OffreEmploi objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OffreEmploi
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
