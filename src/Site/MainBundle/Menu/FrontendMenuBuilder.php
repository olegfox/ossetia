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

        foreach ($menus as $m) {
            if($m->getPage()) {
                if ($m->getPage()->getSlug() == 'novosti') {
                    $child = $menu->addChild($m->getTitle(), array(
                        'route' => 'frontend_news_index',
                        'routeParameters' => array(
                            'type' => 'official'
                        )
                    ));

                    if ($routeName == 'frontend_news_index' || $routeName == 'frontend_news_one') {
                        $child->setCurrent(true);
                    }

                } elseif ($m->getPage()->getSlug() == 'tsitaty') {
                    $child = $menu->addChild($m->getTitle(), array(
                        'route' => 'frontend_quote_index'
                    ));

                    if ($routeName == 'frontend_quote_one') {
                        $child->setCurrent(true);
                    }
                } elseif ($m->getPage()->getSlug() == 'gaziety') {
                    $child = $menu->addChild($m->getTitle(), array(
                        'route' => 'frontend_news_paper_index'
                    ));

                    if ($routeName == 'frontend_news_paper_one') {
                        $child->setCurrent(true);
                    }
                } else {
                    $child = $menu->addChild($m->getTitle(), array(
                        'route' => 'frontend_page_index',
                        'routeParameters' => array(
                            'slug' => $m->getPage()->getSlug()
                        )
                    ));

                    if ($m->getPage()->getSlug() == $request->get('parent') ||
                        ($m->getPage()->getSlug() == 'molodiezhnaia-orghanizatsiia-iedinaia-alaniia' && $routeName == 'frontend_news_young_one')) {
                        $child->setCurrent(true);
                    }
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

    public function subMenu(RequestStack $requestStack)
    {
        $request = $requestStack->getCurrentRequest();

        $routeName = $request->get('_route');

        $em = $this->em;

        $repository = $em->getRepository('SiteMainBundle:Menu');
        $repositoryPage = $em->getRepository('SiteMainBundle:Page');

        $slug = $request->get('parent') ? $request->get('parent') : $request->get('slug');

        $page = $repositoryPage->findOneBy(array('slug' => $slug));

        $menus = $repository->findBy(array('parent' => $page->getMenu()[0]), array('position' => 'asc'));

        $menu = $this->factory->createItem('root');

        $menu->setChildrenAttribute('class', 'nav subnav container black');

        foreach ($menus as $key => $m) {
            $child = $menu->addChild($m->getTitle(), array(
                'route' => 'frontend_subpage_index',
                'routeParameters' => array(
                    'parent' => $slug,
                    'slug' => $m->getPage()->getSlug()
                )
            ));

            if ($m->getPage()->getSlug() == $request->get('parent')) {
                $child->setCurrent(true);
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
            $child = $menu->addChild($key, array(
                'route' => 'frontend_news_index',
                'routeParameters' => array(
                    'type' => $type
                )
            ));

            if ($type == $request->get('type')) {
                $child->setCurrent(true);
            }
        }

        $menu->setCurrent($request->getRequestUri());

        return $menu;
    }

}