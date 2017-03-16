<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VideoController extends Controller
{
    public function indexAction(Request $request)
    {
        $repositoryMedia = $this->getDoctrine()->getRepository('SiteMainBundle:Media');
        $repositoryPage = $this->getDoctrine()->getRepository('SiteMainBundle:Page');

        $videos = $repositoryMedia->findVideos();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $videos,
            $request->query->get('page', 1) /*page number*/,
            5/*limit per page*/
        );

        $page = $repositoryPage->findOneBy(array('slug' => 'vidieoghalieriei'));

        $params = array(
            'videos' => $pagination,
            'page' => $page
        );

        return $this->render('SiteMainBundle:Frontend/Video:index.html.twig', $params);
    }

    public function oneAction($slug)
    {
        $repositoryMedia = $this->getDoctrine()->getRepository('SiteMainBundle:Media');

        $video = $repositoryMedia->findOneBySlug($slug);

        if(!$video){
            throw $this->createNotFoundException($this->get('translator')->trans('backend.video.not_found'));
        }

        $params = array(
            'video' => $video
        );

        return $this->render('SiteMainBundle:Frontend/Video:one.html.twig', $params);
    }
}
