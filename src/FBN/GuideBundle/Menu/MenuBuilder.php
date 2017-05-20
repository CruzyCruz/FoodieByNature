<?php

// src/FBN/GuideBundle/Menu/MenuBuilder.php

namespace FBN\GuideBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return string
     */
    public function createMainMenu()
    {
        $mainmenu = $this->factory->createItem('root');

        $mainmenu->addChild('fbn.guide.mainmenu.infos', array(
            'route' => 'fbn_guide_articles',
            'routeParameters' => array('articles' => 'infos'),
            ));

        $mainmenu->addChild('fbn.guide.mainmenu.restaurants', array(
            'route' => 'fbn_guide_articles',
            'routeParameters' => array('articles' => 'restaurants'),
            ));

        $mainmenu->addChild('fbn.guide.mainmenu.winemakers', array(
            'route' => 'fbn_guide_articles',
            'routeParameters' => array('articles' => 'winemakers'),
            ));

        $mainmenu->addChild('fbn.guide.mainmenu.events', array(
            'route' => 'fbn_guide_articles',
            'routeParameters' => array('articles' => 'events'),
            ));

        $mainmenu->addChild('fbn.guide.mainmenu.tutorials', array(
            'route' => 'fbn_guide_articles',
            'routeParameters' => array('articles' => 'tutorials'),
            ));

        $mainmenu->addChild('fbn.guide.mainmenu.shops', array(
            'route' => 'fbn_guide_articles',
            'routeParameters' => array('articles' => 'shops'),
            ));

        $mainmenu->addChild('fbn.guide.mainmenu.bookmarks', array(
            'route' => 'fbn_guide_bookmarks',
            ));

        return $mainmenu;
    }
}
