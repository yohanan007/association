<?php

namespace OC\GestionBundle\Repository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends \Doctrine\ORM\EntityRepository
{
    public function findArticleByLetter($data)
    {
        $data1 = "%".$data."%";
        $qb = $this->createQueryBuilder('a')
        ->where('a.nom  LIKE :data')
        ->setParameter('data',$data1);
        return $qb
        ->getQuery()
        ->getResult();
    }
}