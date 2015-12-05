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
        $lanenums = array('102', '33 bis', '4 bis', '18', '46', null, null, null, null, null, '22', '7', '8 bis', '41', null, '23', '116', '14');

        $lanenames = array('de Belleville', 'Mademoiselle', 'Jean Aicard', 'Bayen', 'de Turbigo', null, null, null, null, null, 'Ernest Vallé', 'de Gramont', 'Saint Vincent', 'Jobin', 'de Toulouse', 'Dupuy', 'Haussmann', 'de la Madeleine');

        $miscellaneouss = array(null, null, null, null, null, null, null, null, null, null, null, null, null, 'Les Grandes Tables de la Friche', 'Centre Commercial St Caprais', null, null, null);

        $localities = array(null, null, null, null, null, 'Lenthéric', null, 'Laclotte', null, null, null, null, null, null, null, null, null);

        $codepostaux = array('75020', '75015', '75011', '75017', '75003', '34480', '69910', '47250', '81140', '81140', '51190', '31770', '69001', '13003', '31240', '31000', '75008', '25000');

        $coordinatesfrdepts = array(76, 76, 76, 76, 76, 35, 70, 48, 82, 82, 52, 32, 70, 14, 32, 32, 76, 26);

        $coordinatesfrlanes = array(3, 14, 2, 14, 14, null, null, null, null, null, 14, 4, 11, 14, 2, 9, 3, 14);

        foreach ($lanenums as $i => $lanenum) {
            $coordinatesfr[$i] = new CoordFR();
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
