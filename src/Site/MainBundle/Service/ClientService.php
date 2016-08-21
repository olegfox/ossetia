<?php

namespace Site\MainBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ClientService
 * Сервис для экспорта в excel
 * @package Site\Bundle\MainBundle\Service
 */
class ClientService
{

    protected $container;

    protected $em;

    public function __construct(
        Container $container,
        \Doctrine\ORM\EntityManager $em
    ) {
        $this->container = $container;
        $this->em = $em;
    }

    public function export()
    {
        $repository = $this->em->getRepository('SiteMainBundle:Client');

        $clients = $repository->findAll();

        $objPHPExcel = $this->container->get('phpexcel')->createPHPExcelObject('uploads/export.xlsx');
        $sheet = $objPHPExcel->setActiveSheetIndex(0);

//      Заголовки
        $column = 'A';
        $row = 1;

        $headers = array(
            'День регистрации',
            'ФИО',
            'Компания',
            'Email',
            'Отель',
            'Класс номера',
            'Нужно ли встретить',
            'Транспорт',
            'Время прибытия',
            'Вокзал',
            'С кем из сотрудников компании «Ракурс» вы бы хотели пообщаться в ходе конференции?',
            'Напоминание за 2 недели',
            'Напоминание за 1 неделю'
        );

        foreach ($headers as $header)
        {
            $sheet->setCellValue($column . $row, $header);
            $column++;
        }

        foreach ($clients as $client) {
            $row++;

            $column = 'A';

            $info = array(
                false == $client->getRegisterDate() ? '14' : '15',
                $client->getFio(),
                $client->getCompany(),
                $client->getEmail(),
                true == is_object($client->getHotel()) ? $client->getHotel()->getName() : '',
                true == is_object($client->getClassRoom()) ? $client->getClassRoom()->getName() : '',
                false == $client->getMeet() ? 'Нет' : 'Да',
                false == $client->getTransport() ? 'Самолет' : 'Поезд',
                false == is_object($client->getTime()) ? '' : $client->getTime()->format('H:i'),
                true == is_object($client->getStation()) ? $client->getStation() : '',
                $client->getFriends(),
                true == $client->getFlagRemember2() ? 'Отправлено' : 'не отправлено',
                true == $client->getFlagRemember() ? 'Отправлено' : 'не отправлено'
            );

            foreach($info as $inf)
            {
                $sheet->setCellValue($column . $row, $inf);
                $column++;
            }

        }


        $writer = $this->container->get('phpexcel')->createWriter($objPHPExcel, 'Excel2007');

        $response = $this->container->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=export.xlsx');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');

        return $response;
    }
} 