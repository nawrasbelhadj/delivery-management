<?php

namespace App\Repository;

use App\Entity\Courrier;
use App\Entity\TimeLine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TimeLine|null find($id, $lockMode = null, $lockVersion = null)
 * @method TimeLine|null findOneBy(array $criteria, array $orderBy = null)
 * @method TimeLine[]    findAll()
 * @method TimeLine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimeLineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeLine::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(TimeLine $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(TimeLine $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getEventsByCourrier(Courrier $courrier)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.courrier = :courrier')
            ->setParameter('courrier', $courrier)
            ->orderBy('e.updatedAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;

    }

    // /**
    //  * @return TimeLine[] Returns an array of TimeLine objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TimeLine
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
