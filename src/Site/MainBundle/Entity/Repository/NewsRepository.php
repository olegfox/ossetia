<?php

namespace Site\MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Site\MainBundle\Entity\Event;

class NewsRepository extends EntityRepository
{

//  Поиск всех новостей
    public function findAll($flag = 0){
        return $this->createQueryBuilder('n')
            ->where('n.flag = :flag')
            ->orderBy('n.date', 'desc')
            ->setParameter('flag', $flag)
            ->getQuery()
            ->getResult();
    }

//  Поиск по типу новости
    public function findType($type, $flag = 0){
        switch($type){
            case 'official': {
                $typeId = 0;
            }break;
            case 'quickly': {
                $typeId = 1;
            }break;
            case 'meeting': {
                $typeId = 2;
            }break;
            case 'point_view': {
                $typeId = 3;
            }break;
            case 'analytics': {
                $typeId = 4;
            }break;
            default: {
                $typeId = 0;
            }break;
        }

        $news = $this->createQueryBuilder('n')
            ->where('n.type = :type')
            ->andWhere('n.flag = :flag')
            ->orderBy('n.date', 'desc')
            ->setParameters(array(
                'type' =>  $typeId,
                'flag' => $flag
            ))
            ->getQuery()
            ->getResult();

        return $news;

    }

//  Три последние новости
    public function findLast($flag = 0){

        $em = $this->getEntityManager();

        $news = $em->createQuery('
        SELECT n FROM Site\MainBundle\Entity\News n
        WHERE n.flag = :flag
        ORDER BY n.date DESC
        ')
            ->setParameter('flag', $flag)
            ->setMaxResults(4)
            ->getResult();

        return $news;

    }

//  Поиск
    public function findSearch($text){
        $em = $this->getEntityManager();

        $news = $em->createQuery('
            SELECT n FROM Site\MainBundle\Entity\News n
            WHERE n.title LIKE :text
            OR n.description LIKE :text
            OR n.text LIKE :text
            ORDER BY n.date DESC
        ')
        ->setParameters(array(
            'text' => '%' . $text . '%'
        ))
        ->getResult();

        return $news;
    }

}
