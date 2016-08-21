<?php

namespace Site\MainBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class BackendMenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function mainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');

        $menu->setCurrent($requestStack->getCurrentRequest()->getRequestUri());

        $menu->addChild('Меню', array('route' => 'backend_menu_index'));
        $menu->addChild('Статьи', array('route' => 'backend_page_index'));
        $menu->addChild('Новости', array('route' => 'backend_news_index'));
        $menu->addChild('Цитаты', array('route' => 'backend_quote_index'));
        $menu->addChild('Публикации', array('route' => 'backend_news_paper_index'));
        $menu->addChild('Пользователи', array('route' => 'backend_user_index'));

        return $menu;
    }

    public function userMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Выход', array('route' => 'fos_user_security_logout'));

        $menu->setCurrent($requestStack->getCurrentRequest()->getRequestUri());

        return $menu;
    }
}