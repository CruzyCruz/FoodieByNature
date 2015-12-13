<?php

// src/FBN/GuideBundle/DataFixtures/ORM/CoordinatesCountry.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\CoordinatesCountry as CoordCntr;

class CoordinatesCountry extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $countries = array('France');

        $codeisos = array('FR');

        $latitudes = array('46.000000');

        $longitudes = array('2.000000');

        foreach ($countries as $i => $country) {
            $coordinatescountry[$i] = new CoordCntr();
            $coordinatescountry[$i]->setCountry($country);
        }

        foreach ($latitudes as $i => $latitude) {
            $coordinatescountry[$i]->setLatitude($latitude);
        }

        foreach ($longitudes as $i => $longitude) {
            $coordinatescountry[$i]->setLongitude($longitude);
        }

        foreach ($codeisos as $i => $codeiso) {
            $coordinatescountry[$i]->setCodeISO($codeiso);

            $manager->persist($coordinatescountry[$i]);

            $this->addReference('coordinatescountry-'.$i, $coordinatescountry[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 5; // l'ordre dans lequel les fichiers sont chargés
    }
}
