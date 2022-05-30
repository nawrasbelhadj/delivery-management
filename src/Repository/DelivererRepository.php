<?php

namespace App\Repository;

use App\Entity\Deliverer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @method Deliverer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deliverer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deliverer[]    findAll()
 * @method Deliverer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DelivererRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deliverer::class);
    }

    /**
     * Used to upgrade (rehash) the Deliverer's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $deliverer, string $newHashedPassword): void
    {
        if (!$deliverer instanceof Deliverer) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($deliverer)));
        }

        $deliverer->setPassword($newHashedPassword);
        $this->_em->persist($deliverer);
        $this->_em->flush();
    }
    public function saveDeliverer(Deliverer $deliverer) :Deliverer
    {
        $this->getEntityManager()->persist($deliverer);
        $this->getEntityManager()->flush();

        return $deliverer;
    }

    public function deleteDeliverer(Deliverer $deliverer) :void
    {
        $this->getEntityManager()->remove($deliverer);
        $this->getEntityManager()->flush();
    }


}
