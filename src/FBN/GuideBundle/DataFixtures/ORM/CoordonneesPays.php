<?php

// src/FBN/GuideBundle/DataFixtures/ORM/CoordonneesPays.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\CoordonneesPays as CoordPays;

class CoordonneesPays extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $countries = array('France');

        $codeisos = array('FR');

        $latitudes = array('46.000000');

        $longitudes = array('2.000000');

        foreach ($countries as $i => $country) {
            $coordonneespays[$i] = new CoordPays();
            $coordonneespays[$i]->setCountry($country);
        }

        foreach ($latitudes as $i => $latitude) {
            $coordonneespays[$i]->setLatitude($latitude);
        }

        foreach ($longitudes as $i => $longitude) {
            $coordonneespays[$i]->setLongitude($longitude);
        }

        foreach ($codeisos as $i => $codeiso) {
            $coordonneespays[$i]->setCodeISO($codeiso);

            $manager->persist($coordonneespays[$i]);

            $this->addReference('coordonneespays-'.$i, $coordonneespays[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 5; // l'ordre dans lequel les fichiers sont chargés
    }
}
