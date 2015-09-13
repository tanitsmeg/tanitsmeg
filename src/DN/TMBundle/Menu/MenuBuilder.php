<?php

namespace DN\TMBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class MenuBuilder {

    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory) {
        $this->factory = $factory;
    }

    public function createMainMenu(Request $request) {
        $menu = $this->factory->createItem('root');

        $menu->addChild('Show A', array('route' => 'show_course', array('productCode', '')))
                ->addChild('Show A2', array('route' => 'show_course', array('productCode', '')));

        return $menu;
    }
    
}