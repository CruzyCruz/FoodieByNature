<?php

// src/FBN/GuideBundle/DataFixtures/ORM/RestaurantPrice.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\RestaurantPrice as RestrntPrice;

class RestaurantPrice extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $prices = array('Moins de 15€', 'De 15 à 35€', 'De 35 à 50€', 'De 50 à 100€');

        $pricesen = array('Less than €15', '€15 to €35', '€35 to €50', '€50 to €100');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($prices as $i => $price) {
            $restaurantprice[$i] = new RestrntPrice();
            $restaurantprice[$i]->setPrice($price);

            $repository->translate($restaurantprice[$i], 'price', 'en', $pricesen[$i]);

            $manager->persist($restaurantprice[$i]);

            $this->addReference('restaurantprice-'.$i, $restaurantprice[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 302; // l'ordre dans lequel les fichiers sont chargés
    }
}
