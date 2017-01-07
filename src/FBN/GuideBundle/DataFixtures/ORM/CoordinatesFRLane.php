<?php

namespace FBN\GuideBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\CoordinatesFRLane as CoordFRLane;

class CoordinatesFRLane extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $lanes = array(
                        'allée',
                        'avenue',
                        'boulevard',
                        'chemin',
                        'cours',
                        'esplanade',
                        'impasse',
                        'passage',
                        'place',
                        'pont',
                        'quai',
                        'rond-point',
                        'route',
                        'rue',
                        'square',
                        'traverse',
                        );

        foreach ($lanes as $i => $lane) {
            $coordinatesfrlane[$i] = new CoordFRLane();
            $coordinatesfrlane[$i]->setLane($lane);

            $manager->persist($coordinatesfrlane[$i]);

            $this->addReference('coordinatesfrlane-'.$i, $coordinatesfrlane[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 12;
    }
}
