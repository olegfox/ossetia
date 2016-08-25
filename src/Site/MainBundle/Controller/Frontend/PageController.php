<?php

namespace Site\MainBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    public function indexAction($parent = null, $slug)
    {
        $repository = $this->getDoctrine()->getRepository('SiteMainBundle:Page');

        $page = $repository->findOneBySlug($slug);

        if (!$page)
        {
            throw $this->createNotFoundException($this->get('translator')->trans('Страница не найдена'));
        }

        $params = array(
            "page" => $page
        );

        if ($slug == 'fotoghalieriei') {
            $repository_media = $this->getDoctrine()->getRepository('SiteMainBundle:Media');

            $params = array_merge($params, array(
                'media' => $repository_media->findPhoto()
            ));
        }

        return $this->render('SiteMainBundle:Frontend/Page:index.html.twig', $params);
    }
}
