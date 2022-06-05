<?php

namespace App\Repository;

use App\Entity\Courrier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Courrier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Courrier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Courrier[]    findAll()
 * @method Courrier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourrierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Courrier::class);
    }

    public function deleteCourrier(Courrier $courrier) :void
    {
        $this->getEntityManager()->remove($courrier);
        $this->getEntityManager()->flush();
    }

    public function saveCourrier(Courrier $courrier) :Courrier
    {
        $this->getEntityManager()->persist($courrier);
        $this->getEntityManager()->flush();

        return $courrier;
    }

    /**
     * @return Courrier[] Returns an array of Courrier objects
     *
     */
    public function findCourrierByFilter(array $filter)
    {
        $query = $this->createQueryBuilder('c');

        if (array_key_exists("postDeparture", $filter)) {
            $query->andWhere("c.postDeparture = :postDeparture");
            $query->setParameter('postDeparture', $filter["postDeparture"]);
        }

        if (array_key_exists("typeCourrier", $filter)) {
            $query->andWhere("c.typeCourrier = :typeCourrier");
            $query->setParameter('typeCourrier', $filter["typeCourrier"]);
        }

        if (array_key_exists("fromDate", $filter) && array_key_exists("toDate", $filter)) {
            $query->andWhere("c.createdAt BETWEEN :fromDate AND :toDate");
            $query->setParameter('fromDate', $filter["fromDate"]);
            $query->setParameter('toDate', $filter["toDate"]);
        }

        return $query->getQuery()
            ->getResult();
    }





    // /**
    //  * @return Courrier[] Returns an array of Courrier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Courrier
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
