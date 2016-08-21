<?php

namespace Site\MainBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Site\MainBundle\Entity\Event;

class NewsRepository extends EntityRepository
{

//  Поиск всех новостей
    public function findAll(){
        return $this->createQueryBuilder('n')
            ->orderBy('n.date', 'desc')
            ->getQuery()
            ->getResult();
    }

//  Поиск всех новостей + разбивание по типам
    public function findAllForType(){
        $news = $this->findAll();

        $newsArray = array('events' => array(), 'interviews' => array(), 'opinion' => array());

        foreach($news as $n){
            if($n->getType() == 0){
                if(count($newsArray['events']) == 4) continue;
                $newsArray['events'][] = $n;
            }elseif($n->getType() == 1){
                if(count($newsArray['interviews']) == 4) continue;
                $newsArray['interviews'][] = $n;
            }elseif($n->getType() == 2){
                if(count($newsArray['opinion']) == 4) continue;
                $newsArray['opinion'][] = $n;
            }
        }

        return $newsArray;
    }

//  Поиск по типу новости
    public function findType($type){
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
            ->orderBy('n.date', 'desc')
            ->setParameter('type', $typeId)
            ->getQuery()
            ->getResult();

        return $news;

    }

//  Три последние новости
    public function findLast(){

        $em = $this->getEntityManager();

        $news = $em->createQuery('
        SELECT n FROM Site\MainBundle\Entity\News n
        ORDER BY n.date DESC
        ')
            ->setMaxResults(4)
            ->getResult();

        return $news;

    }

//  Поиск новостей по типу события
    public function findByEventType($typeEvent){

        switch($typeEvent){
            case 'chiempionat': {
                $typeNumber = Event::NAME_CHAMPIONSHIP;
            }break;
            case 'kubok': {
                $typeNumber = Event::NAME_CUP;
            }break;
            case 'ligha-ievropy': {
                $typeNumber = Event::NAME_EUROPA_LEAGUE;
            }break;
            case 'dubliruiushchii-sostav-1': {
                $typeNumber = Event::NAME_YOUTH_CHAMPIONSHIP;
            }break;
            default: {
                $typeNumber = Event::NAME_CHAMPIONSHIP;
            }break;
        }

        $news = $this->findBy(array('typeEvent' => $typeNumber), array('date' => 'DESC'));

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
