<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    public function indexAction(Request $request, $type)
    {
        $repository = $this->getDoctrine()->getRepository('SiteMainBundle:News');

        $news = $repository->findType($type);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $news,
            $request->query->get('page', 1) /*page number*/,
            5/*limit per page*/
        );

        $params = array(
            'news' => $pagination
        );

        return $this->render('SiteMainBundle:Frontend/News:index.html.twig', $params);
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
}
