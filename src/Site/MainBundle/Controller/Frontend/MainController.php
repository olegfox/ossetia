<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        $repositoryPage = $this->getDoctrine()->getRepository('SiteMainBundle:Page');
        $repositoryNews = $this->getDoctrine()->getRepository('SiteMainBundle:News');
        $repositoryQuote = $this->getDoctrine()->getRepository('SiteMainBundle:Quote');

        $page = $repositoryPage->findAll()[0];
        $news = $repositoryNews->findLast();
        $quotes = $repositoryQuote->findLast();

        if (!$page)
        {
            throw $this->createNotFoundException($this->get('translator')->trans('Страница не найдена'));
        }

        $params = array(
            "page" => $page,
            "news" => $news,
            "quotes" => $quotes
        );

        return $this->render('SiteMainBundle:Frontend/Main:index.html.twig', $params);
    }
}
