<?php

namespace Site\MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class PhotoRepository extends EntityRepository
{
    public function findAll(){
        return $this->findBy(array(), array('created' => 'DESC'));
    }
    public function findOneBySlug($slug){
        $photo =  $this->getEntityManager()->createQuery(
            'SELECT p FROM SiteMainBundle:Photo p
            WHERE p.slug LIKE :slug OR p.id = :slug'
        )
            ->setParameter('slug', $slug)
            ->getResult();

        if(count($photo) > 0){
            if(is_object($photo[0])){
                return $photo[0];
            }
        }

        return false;
    }
}
