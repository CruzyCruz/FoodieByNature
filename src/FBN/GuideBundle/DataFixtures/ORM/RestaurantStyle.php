<?php

// src/FBN/GuideBundle/DataFixtures/ORM/RestaurantStyle.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\RestaurantStyle as RestrntStyle;

class RestaurantStyle extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $styles = array('Cave à Manger', 'Bistronomie', 'Masterchef', 'Street Food');

        $stylesen = array('Wine bar', 'Bistronomy', 'Masterchef', 'Street Food');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($styles as $i => $style) {
            $restaurantstyle[$i] = new RestrntStyle();
            $restaurantstyle[$i]->setStyle($style);

            $repository->translate($restaurantstyle[$i], 'style', 'en', $stylesen[$i]);

            $manager->persist($restaurantstyle[$i]);

            $this->addReference('restaurantstyle-'.$i, $restaurantstyle[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 303; // l'ordre dans lequel les fichiers sont chargés
    }
}
