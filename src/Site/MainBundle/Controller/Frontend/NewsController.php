<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    public function indexAction(Request $request, $type)
    {
        $repository = $this->getDoctrine()->getRepository('SiteMainBundle:News');
        $repositoryPage = $this->getDoctrine()->getRepository('SiteMainBundle:Page');

        $news = $repository->findType($type);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $news,
            $request->query->get('page', 1) /*page number*/,
            5/*limit per page*/
        );

        $page = $repositoryPage->findOneBy(array('slug' => 'novosti'));

        $params = array(
            'news' => $pagination,
            'page' => $page
        );

        return $this->render('SiteMainBundle:Frontend/News:index.html.twig', $params);
    }

    public function ajaxAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SiteMainBundle:News');
        $repositoryPage = $this->getDoctrine()->getRepository('SiteMainBundle:Page');

        $news = $repository->findAll(1);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $news,
            $request->query->get('page', 1) /*page number*/,
            5/*limit per page*/
        );

        $page = $repositoryPage->findOneBy(array('slug' => 'novosti-1'));

        $params = array(
            'news' => $pagination,
            'page' => $page
        );

        return $this->render('SiteMainBundle:Frontend/News:ajax.html.twig', $params);
    }

    public function oneAction($slug)
    {
        $repository = $this->getDoctrine()->getRepository('SiteMainBundle:News');

        $news = $repository->findOneBySlug($slug);

        if(!$news){
            throw $this->createNotFoundException($this->get('translator')->trans('backend.news.not_found'));
        }

        $params = array(
            'news' => $news
        );

        return $this->render('SiteMainBundle:Frontend/News:one.html.twig', $params);
    }

    public function oneYoungAction($slug)
    {
        $repository = $this->getDoctrine()->getRepository('SiteMainBundle:News');

        $news = $repository->findOneBySlug($slug);

        if(!$news){
            throw $this->createNotFoundException($this->get('translator')->trans('backend.news.not_found'));
        }

        $params = array(
            'news' => $news
        );

        return $this->render('SiteMainBundle:Frontend/News:one.html.twig', $params);
    }
}
