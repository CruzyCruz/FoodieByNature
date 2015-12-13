<?php

// src/FBN/GuideBundle/DataFixtures/ORM/CoordinatesFRArea.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\CoordinatesFRArea as CoordFRArea;

class CoordinatesFRArea extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $areas = array(
                        'Guadeloupe',
                        'Martinique',
                        'Guyane',
                        'La Réunion',
                        'Mayotte',
                        'Île-de-France',
                        'Champagne-Ardenne',
                        'Picardie',
                        'Haute-Normandie',
                        'Centre',
                        'Basse-Normandie',
                        'Bourgogne',
                        'Nord-Pas-de-Calais',
                        'Lorraine',
                        'Alsace',
                        'Franche-Comté',
                        'Pays de la Loire',
                        'Bretagne',
                        'Poitou-Charentes',
                        'Aquitaine',
                        'Midi-Pyrénées',
                        'Limousin',
                        'Rhône-Alpes',
                        'Auvergne',
                        'Languedoc-Roussillon',
                        'Provence-Alpes-Côte d\'Azur',
                        'Corse',
                        );

        foreach ($areas as $i => $area) {
            $coordinatesfrarea[$i] = new CoordFRArea();
            $coordinatesfrarea[$i]->setArea($area);

            $manager->persist($coordinatesfrarea[$i]);

            $this->addReference('coordinatesfrarea-'.$i, $coordinatesfrarea[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1; // l'ordre dans lequel les fichiers sont chargés
    }
}
