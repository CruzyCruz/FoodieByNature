<?php

// src/FBN/GuideBundle/DataFixtures/ORM/CoordinatesFR.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\CoordinatesFR as CoordFR;

class CoordinatesFR extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $latitudes = array(48.870614, 48.843902, 48.864877, 48.880278, 48.865307, 43.519845, 46.161263, 44.451322, 43.983802, 43.519844, 48.970947, 43.625832, 45.768889, 43.312079, 43.656380, 43.599976, 48.875205, 47.241010);

        $longitudes = array(2.379013, 2.296634, 2.381744, 2.294396, 2.354984, 3.142942, 4.678721, 0.039742, 1.908697, 3.142941, 4.008447, 1.342816, 4.816100, 5.390889, 1.478631, 1.453761, 2.318872, 6.018815);

        $citys = array('Paris', 'Paris', 'Paris', 'Paris', 'Paris', 'Cabrerolles', 'Villié-Morgon', 'Cocumont', 'Cahuzac-Sur-Vère', 'Cahuzac-Sur-Vère', 'Avize', 'Colomiers', 'Lyon', 'Marseille', 'L\'Union', 'Toulouse', 'Paris', 'Besançon');

        $metros = array('Bellevile, Couronne','Avenue Emile Zola, Félix Faure, Commerce', 'Ménilmontant, Parmentier, Rue Saint-Maur', 'Ternes', 'Arts et Métiers', null, null, null, null, null, null, null, 'Gorge de Loup', 'Chartreux', null, 'François-Verdier', 'Saint-Augustin', null);

        $lanenums = array('102', '33 bis', '4 bis', '18', '46', null, null, null, null, null, '22', '7', '8 bis', '41', null, '23', '116', '14');

        $lanenames = array('de Belleville', 'Mademoiselle', 'Jean Aicard', 'Bayen', 'de Turbigo', null, null, null, null, null, 'Ernest Vallé', 'de Gramont', 'Saint Vincent', 'Jobin', 'de Toulouse', 'Dupuy', 'Haussmann', 'de la Madeleine');

        $miscellaneouss = array(null, null, null, null, null, null, null, null, null, null, null, null, null, 'Les Grandes Tables de la Friche', 'Centre Commercial St Caprais', null, null, null);

        $localities = array(null, null, null, null, null, 'Lenthéric', null, 'Laclotte', null, null, null, null, null, null, null, null, null);

        $codepostaux = array('75020', '75015', '75011', '75017', '75003', '34480', '69910', '47250', '81140', '81140', '51190', '31770', '69001', '13003', '31240', '31000', '75008', '25000');

        $coordinatesfrdepts = array(76, 76, 76, 76, 76, 35, 70, 48, 82, 82, 52, 32, 70, 14, 32, 32, 76, 26);

        $coordinatesfrlanes = array(3, 14, 2, 14, 14, null, null, null, null, null, 14, 4, 11, 14, 2, 9, 3, 14);

        foreach ($latitudes as $i => $latitude) {
            $coordinatesfr[$i] = new CoordFR();
            $coordinatesfr[$i]->setLatitude($latitude);
        }

        foreach ($longitudes as $i => $longitude) {
            $coordinatesfr[$i]->setLongitude($longitude);
        }

        foreach ($citys as $i => $city) {
            $coordinatesfr[$i]->setCity($city);
        }

        foreach ($metros as $i => $metro) {
            $coordinatesfr[$i]->setMetro($metro);
        }

        foreach ($lanenums as $i => $lanenum) {
            $coordinatesfr[$i]->setLaneNum($lanenum);
        }

        foreach ($lanenames as $i => $lanename) {
            $coordinatesfr[$i]->setLaneName($lanename);
        }

        foreach ($miscellaneouss as $i => $miscellaneous) {
            $coordinatesfr[$i]->setMiscellaneous($miscellaneous);
        }

        foreach ($localities as $i => $locality) {
            $coordinatesfr[$i]->setLocality($locality);
        }

        foreach ($codepostaux as $i => $codepostal) {
            $coordinatesfr[$i]->setPostcode($codepostal);

            $manager->persist($coordinatesfr[$i]);

            $coordinatesfr[$i]->setCoordinatesFRDept($this->getReference('coordinatesfrdept-'.($coordinatesfrdepts[$i] - 1)));

            if ($coordinatesfrlanes[$i]) {
                $coordinatesfr[$i]->setCoordinatesFRLane($this->getReference('coordinatesfrlane-'.($coordinatesfrlanes[$i] - 1)));
            }

            $this->addReference('coordinatesfr-'.$i, $coordinatesfr[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 4; // l'ordre dans lequel les fichiers sont chargés
    }
}
