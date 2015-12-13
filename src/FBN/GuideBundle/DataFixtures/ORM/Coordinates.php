<?php

// src/FBN/GuideBundle/DataFixtures/ORM/Coordinates.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Coordinates as Coord;

class Coordinates extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $latitudes = array(48.870614, 48.843902, 48.864877, 48.880278, 48.865307, 43.519845, 46.161263, 44.451322, 43.983802, 43.519844, 48.970947, 43.625832, 45.768889, 43.312079, 43.656380, 43.599976, 48.875205, 47.241010);

        $longitudes = array(2.379013, 2.296634, 2.381744, 2.294396, 2.354984, 3.142942, 4.678721, 0.039742, 1.908697, 3.142941, 4.008447, 1.342816, 4.816100, 5.390889, 1.478631, 1.453761, 2.318872, 6.018815);

        $citys = array('Paris', 'Paris', 'Paris', 'Paris', 'Paris', 'Cabrerolles', 'Villié-Morgon', 'Cocumont', 'Cahuzac-Sur-Vère', 'Cahuzac-Sur-Vère', 'Avize', 'Colomiers', 'Lyon', 'Marseille', 'L\'Union', 'Toulouse', 'Paris', 'Besançon');

        $metros = array('Bellevile, Couronne','Avenue Emile Zola, Félix Faure, Commerce', 'Ménilmontant, Parmentier, Rue Saint-Maur', 'Ternes', 'Arts et Métiers', null, null, null, null, null, null, null, 'Gorge de Loup', 'Chartreux', null, 'François-Verdier', 'Saint-Augustin', null);

        foreach ($latitudes as $i => $latitude) {
            $coordinates[$i] = new Coord();
            $coordinates[$i]->setLatitude($latitude);
        }

        foreach ($longitudes as $i => $longitude) {
            $coordinates[$i]->setLongitude($longitude);
        }

        foreach ($citys as $i => $city) {
            $coordinates[$i]->setCity($city);
        }

        foreach ($metros as $i => $metro) {
            $coordinates[$i]->setMetro($metro);

            $manager->persist($coordinates[$i]);

            $coordinates[$i]->setCoordinatesFR($this->getReference('coordinatesfr-'.$i));
            $coordinates[$i]->setCoordinatesCountry($this->getReference('coordinatescountry-0'));

            $this->addReference('coordinates-'.$i, $coordinates[$i]);
        }

        /*foreach($tels as $i => $tel)
        {
            $coordinates[$i]->setTel($tel);

            $manager->persist($coordinates[$i]);

            $coordinates[$i]->setCoordinatesFR($this->getReference('coordinatesfr-' . $i));
            $coordinates[$i]->setCoordinatesCountry($this->getReference('coordinatescountry-0'));

            $this->addReference('coordinates-' . $i, $coordinates[$i]);            
        }  */

        $manager->flush();
    }

    public function getOrder()
    {
        return 6; // l'ordre dans lequel les fichiers sont chargés
    }
}
