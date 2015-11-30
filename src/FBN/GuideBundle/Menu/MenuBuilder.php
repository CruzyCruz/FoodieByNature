<?php
// src/FBN/GuideBundle/Menu/MenuBuilder.php

namespace FBN\GuideBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

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
     * @param Request $request
     * @return string 
     */
    public function createMainMenu(Request $request)
    {

        $mainmenu = $this->factory->createItem('root');


        $mainmenu->addChild('fbn.guide.mainmenu.infos' , array(
            'route'           => 'fbn_guide_articles',
            'routeParameters' => array( 'articles' => 'infos' )
            ));

        $mainmenu->addChild('fbn.guide.mainmenu.restaurants' , array(
            'route'           => 'fbn_guide_articles',
            'routeParameters' => array( 'articles' => 'restaurants' )
            ));        

        $mainmenu->addChild('fbn.guide.mainmenu.winemakers' , array(
            'route'           => 'fbn_guide_articles',
            'routeParameters' => array( 'articles' => 'winemakers' )
            ));   

        $mainmenu->addChild('fbn.guide.mainmenu.events' , array(
            'route'           => 'fbn_guide_articles',
            'routeParameters' => array( 'articles' => 'events' )
            ));      
        
        $mainmenu->addChild('fbn.guide.mainmenu.tutorials' , array(
            'route'           => 'fbn_guide_articles',
            'routeParameters' => array( 'articles' => 'tutorials' )
            ));   

        $mainmenu->addChild('fbn.guide.mainmenu.cavistes' , array(
            'route'           => 'fbn_guide_articles',
            'routeParameters' => array( 'articles' => 'cavistes' )
            ));

        $mainmenu->addChild('fbn.guide.mainmenu.favoris' , array(
            'route'           => 'fbn_guide_favoris'
            ));                                                     

        return $mainmenu;
    }    

}