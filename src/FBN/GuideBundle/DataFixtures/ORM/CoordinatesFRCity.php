<?php

namespace FBN\GuideBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\CoordinatesFRCity as CoordFRCity;

class CoordinatesFRCity extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $csv = fopen(dirname(__FILE__).'/Resources/Coordinates/CoordinatesFRCity-extract.csv', 'r');
        //$csv = fopen(dirname(__FILE__).'/Resources/Coordinates/CoordinatesFRCity.csv', 'r');

        $batchSize = 20;
        $i = 0;

        // Disable SQL logger
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        while (!feof($csv)) {
            $line = fgetcsv($csv);

            $coordinatesfrcity = new CoordFRCity();
            $coordinatesfrcity->setAreaPre2016($line[0]);
            $coordinatesfrcity->setAreaPost2016($line[1]);
            $coordinatesfrcity->setDeptNum($line[2]);
            $coordinatesfrcity->setDeptName($line[3]);
            $coordinatesfrcity->setdistrict($line[4]);
            $coordinatesfrcity->setpostCode($line[5]);
            $coordinatesfrcity->setCity($line[6]);

            $manager->persist($coordinatesfrcity);

            $this->addReference('coordinatesfrcity-'.$i, $coordinatesfrcity);

            if (($i % $batchSize) === 0) {
                $manager->flush();
                $manager->clear();
            }

            $manager->flush();

            $i = $i + 1;
        }

        fclose($csv);

        $manager->flush();
        $manager->clear();
    }

    public function getOrder()
    {
        return 1;
    }
}
