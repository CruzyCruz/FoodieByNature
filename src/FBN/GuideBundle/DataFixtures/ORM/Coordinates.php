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
        for ($i = 0; $i <= 17; ++$i) {
            $coordinates[$i] = new Coord();

            $manager->persist($coordinates[$i]);

            $coordinates[$i]->setCoordinatesFR($this->getReference('coordinatesfr-'.$i));
            $coordinates[$i]->setCoordinatesCountry($this->getReference('coordinatescountry-0'));

            $this->addReference('coordinates-'.$i, $coordinates[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 5; // l'ordre dans lequel les fichiers sont chargés
    }
}
