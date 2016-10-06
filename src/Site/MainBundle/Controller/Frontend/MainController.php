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
        $repositorySlider = $this->getDoctrine()->getRepository('SiteMainBundle:Slider');
        $repositoryMedia = $this->getDoctrine()->getRepository('SiteMainBundle:Media');

        $page = $repositoryPage->findAll()[0];
        $news = $repositoryNews->findLast();
        $newsYoung = $repositoryNews->findLast(1);
        $quotes = $repositoryQuote->findLast();
        $sliders = $repositorySlider->findBy(array('main' => true), array('position' => 'desc'));
        $photo = $repositoryMedia->findLastPhoto();
        $video = $repositoryMedia->findLastVideo();

        if (!$page)
        {
            throw $this->createNotFoundException($this->get('translator')->trans('Страница не найдена'));
        }

        $params = array(
            "page" => $page,
            "news" => $news,
            "newsYoung" => $newsYoung,
            "quotes" => $quotes,
            "sliders" => $sliders,
            "photo" => $photo[0],
            "video" => $video[0]
        );

        return $this->render('SiteMainBundle:Frontend/Main:index.html.twig', $params);
    }
}
