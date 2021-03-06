<?php

namespace OC\UserBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
     public function findUserJour($idJour)
    {
        $qb = $this->createQueryBuilder('u')
        ->innerJoin('u.presents','pres')
        ->addSelect('pres')
        ->where('pres.id=:id')
        ->setParameter('id',$idJour);
        return $qb;
    }
}
