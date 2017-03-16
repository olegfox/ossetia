<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsPaperController extends Controller
{
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SiteMainBundle:NewsPaper');
        $repositoryPage = $this->getDoctrine()->getRepository('SiteMainBundle:Page');

        $newsPapers = $repository->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $newsPapers,
            $request->query->get('page', 1) /*page number*/,
            5/*limit per page*/
        );

        $page = $repositoryPage->findOneBy(array('slug' => 'gaziety'));

        $params = array(
            'newsPapers' => $pagination,
            'page' => $page
        );

        return $this->render('SiteMainBundle:Frontend/NewsPaper:index.html.twig', $params);
    }

    public function oneAction($slug)
    {
        $repository = $this->getDoctrine()->getRepository('SiteMainBundle:NewsPaper');

        $newsPaper = $repository->findOneBySlug($slug);

        if(!$newsPaper){
            throw $this->createNotFoundException($this->get('translator')->trans('backend.newsPaper.not_found'));
        }

        $params = array(
            'newsPaper' => $newsPaper
        );

        return $this->render('SiteMainBundle:Frontend/NewsPaper:one.html.twig', $params);
    }
}
