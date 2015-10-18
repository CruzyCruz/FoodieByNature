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

        $mainmenu->addChild('fbn.guide.mainmenu.vignerons' , array(
            'route'           => 'fbn_guide_articles',
            'routeParameters' => array( 'articles' => 'vignerons' )
            ));   

        $mainmenu->addChild('fbn.guide.mainmenu.evenements' , array(
            'route'           => 'fbn_guide_articles',
            'routeParameters' => array( 'articles' => 'evenements' )
            ));      
        
        $mainmenu->addChild('fbn.guide.mainmenu.tutoriels' , array(
            'route'           => 'fbn_guide_articles',
            'routeParameters' => array( 'articles' => 'tutoriels' )
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