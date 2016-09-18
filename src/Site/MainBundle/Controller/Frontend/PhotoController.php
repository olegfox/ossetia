<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PhotoController extends Controller
{
    public function indexAction(Request $request)
    {
        $repositoryMedia = $this->getDoctrine()->getRepository('SiteMainBundle:Media');
        $repositoryPage = $this->getDoctrine()->getRepository('SiteMainBundle:Page');

        $photos = $repositoryMedia->findPhotos();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $photos,
            $request->query->get('page', 1) /*page number*/,
            5/*limit per page*/
        );

        $page = $repositoryPage->findOneBy(array('slug' => 'fotoghalieriei'));

        $params = array(
            'photos' => $pagination,
            'page' => $page
        );

        return $this->render('SiteMainBundle:Frontend/Photo:index.html.twig', $params);
    }

    public function oneAction($slug)
    {
        $repositoryMedia = $this->getDoctrine()->getRepository('SiteMainBundle:Media');

        $photo = $repositoryMedia->findOneBySlug($slug);

        if(!$photo){
            throw $this->createNotFoundException($this->get('translator')->trans('backend.photo.not_found'));
        }

        $params = array(
            'photo' => $photo
        );

        return $this->render('SiteMainBundle:Frontend/Photo:one.html.twig', $params);
    }
}
