<?php
use OC\GestionBundle\Entity\Image;
use OC\GestionBundle\Entity\Article;

namespace OC\GestionBundle\Repository;

/**
 * SectionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SectionRepository extends \Doctrine\ORM\EntityRepository
{
   public function findJoinSection($id)
   {
       $qb = $this->createQueryBuilder('sel')
       ->innerjoin('sel.articles','art')
       ->addSelect('art')
       ->innerjoin('art.images','im')
       ->addSelect('im')
       ->where('sel.id = :id')
       ->setParameter('id',$id);
       
       return $qb
       ->getQuery()
       ->getResult();
   }
}
