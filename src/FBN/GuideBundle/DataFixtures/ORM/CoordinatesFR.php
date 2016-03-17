<?php

namespace FBN\GuideBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\CoordinatesFR as CoordFR;

class CoordinatesFR extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $metros = array('St Cyprien', 'Avenue Emile Zola, Félix Faure, Commerce', 'Ménilmontant, Parmentier, Rue Saint-Maur', 'Ternes', 'Arts et Métiers', null, null, null, null, null, null, null, 'Gorge de Loup', 'Chartreux', null, 'François-Verdier', 'Saint-Augustin', null);

        $lanenums = array('9', '33 bis', '4 bis', '18', '46', null, null, null, null, null, '22', '7', '8 bis', '41', null, '23', '116', '14');

        $lanenames = array('de l\'Estrapade', 'Mademoiselle', 'Jean Aicard', 'Bayen', 'de Turbigo', null, null, null, null, null, 'Ernest Vallé', 'de Gramont', 'Saint Vincent', 'Jobin', 'de Toulouse', 'Dupuy', 'Haussmann', 'de la Madeleine');

        $miscellaneouss = array(null, null, null, null, null, null, null, null, null, null, null, null, null, 'Les Grandes Tables de la Friche', 'Centre Commercial St Caprais', null, null, null);

        $localities = array(null, null, null, null, null, 'Lenthéric', null, 'Laclotte', null, null, null, null, null, null, null, null, null, null);

        $coordinatesfrcities = array(54, 34, 50, 37, 49, 18, 25, 28, 19, 47, 14, 4, 11, 14, 2, 9, 3, 14);

        $coordinatesfrlanes = array(9, 14, 2, 14, 14, null, null, null, null, null, 14, 4, 11, 14, 2, 9, 3, 14);

        $country = 'France';

        foreach ($metros as $i => $metro) {
            $coordinatesfr[$i] = new CoordFR();
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
            $coordinatesfr[$i]->setCountry($country);

            $manager->persist($coordinatesfr[$i]);

            $coordinatesfr[$i]->setCoordinatesFRCity($this->getReference('coordinatesfrcity-'.($coordinatesfrcities[$i] - 1)));

            if ($coordinatesfrlanes[$i]) {
                $coordinatesfr[$i]->setCoordinatesFRLane($this->getReference('coordinatesfrlane-'.($coordinatesfrlanes[$i] - 1)));
            }

            $this->addReference('coordinatesfr-'.$i, $coordinatesfr[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
