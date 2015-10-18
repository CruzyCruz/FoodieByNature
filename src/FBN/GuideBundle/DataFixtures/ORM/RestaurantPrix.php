<?php
// src/FBN/GuideBundle/DataFixtures/ORM/RestaurantPrix.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\RestaurantPrix as RestoPrix;

class RestaurantPrix extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $prixx = array('Moins de 15€', 'De 15 à 35€', 'De 35 à 50€', 'De 50 à 100€');     

        $prixxen = array('Less than €15', '€15 to €35', '€35 to €50', '€50 to €100');  

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');                

        foreach($prixx as $i => $prix)
        {
            $restaurantprix[$i] = new RestoPrix();
            $restaurantprix[$i]->setPrix($prix);

            $repository->translate($restaurantprix[$i], 'prix', 'en', $prixxen[$i]); 

            $manager->persist($restaurantprix[$i]);

            $this->addReference('restaurantprix-' . $i, $restaurantprix[$i]);
        }   

        $manager->flush();
    }

    public function getOrder()
    {
        return 302; // l'ordre dans lequel les fichiers sont chargés
    }  
}