<?php

namespace Site\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use \Doctrine\ORM\EntityManager as EntityManager;

class FrontendMenuBuilder
{
    private $factory;
    private $container;
    private $em;

    /**
     * @param FactoryInterface $factory
     * @param Container $container
     * @param EntityManager $em
     */
    public function __construct(
        FactoryInterface $factory,
        Container $container,
        EntityManager $em
    )
    {
        $this->factory = $factory;
        $this->container = $container;
        $this->em = $em;
    }

    public function mainMenu(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();

        $routeName = $request->get('_route');

        $em = $this->em;

        $repository = $em->getRepository('SiteMainBundle:Menu');

        $menus = $repository->findBy(array('parent' => null), array('position' => 'asc'));

        $menu = $this->factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav nav-pills black');

        foreach ($menus as $key => $m) {
            if($m->getPage()) {
                if ($m->getPage()->getSlug() == 'novosti') {
                    $menu->addChild($m->getTitle(), array(
                        'route' => 'frontend_news_index',
                        'routeParameters' => array(
                            'type' => 'official'
                        )
                    ));
                } else {
                    $menu->addChild($m->getTitle(), array(
                        'route' => 'frontend_page_index',
                        'routeParameters' => array(
                            'slug' => $m->getPage()->getSlug()
                        )
                    ));
                }
            } else {
                $menu->addChild($m->getTitle(), array(
                    'route' => 'frontend_homepage',
                ));
            }
        }

        $menu->setCurrent($request->getRequestUri());

        return $menu;
    }

    public function newsTypeMenu(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();

        $menu = $this->factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav subnav container black');

        $types = array(
            'Официально' => 'official',
            'Срочно' => 'quickly',
            'Встречи с населением' => 'meeting',
            'Точка зрения' => 'point_view',
            'Аналитика' => 'analytics'
        );

        foreach ($types as $key => $type) {
            $menu->addChild($key, array(
                'route' => 'frontend_news_index',
                'routeParameters' => array(
                    'type' => $type
                )
            ));
        }

        $menu->setCurrent($request->getRequestUri());

        return $menu;
    }
}