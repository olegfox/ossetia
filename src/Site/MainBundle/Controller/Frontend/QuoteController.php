<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuoteController extends Controller
{
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('SiteMainBundle:Quote');
        $repositoryPage = $this->getDoctrine()->getRepository('SiteMainBundle:Page');

        $quotes = $repository->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $quotes,
            $request->query->get('page', 1) /*page number*/,
            5/*limit per page*/
        );

        $page = $repositoryPage->findOneBy(array('slug' => 'tsitaty'));

        $params = array(
            'quotes' => $pagination,
            'page' => $page
        );

        return $this->render('SiteMainBundle:Frontend/Quote:index.html.twig', $params);
    }

    public function oneAction($slug)
    {
        $repository = $this->getDoctrine()->getRepository('SiteMainBundle:Quote');

        $quote = $repository->findOneBySlug($slug);

        if(!$quote){
            throw $this->createNotFoundException($this->get('translator')->trans('backend.quote.not_found'));
        }

        $params = array(
            'quote' => $quote
        );

        return $this->render('SiteMainBundle:Frontend/Quote:one.html.twig', $params);
    }
}
