<?php

// src/FBN/GuideBundle/DataFixtures/ORM/WinemakerArea.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\WinemakerArea as WmkrArea;

class WinemakerArea extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $areasfr = array(
            '(FRA) Alsace',
            '(FRA) Auvergne',
            '(FRA) Beaujolais',
            '(FRA) Bordelais',
            '(FRA) Bourgogne',
            '(FRA) Centre',
            '(FRA) Champagne',
            '(FRA) Corse',
            '(FRA) Jura',
            '(FRA) Languedoc',
            '(FRA) Loire',
            '(FRA) Provence',
            '(FRA) Roussillon',
            '(FRA) Savoie',
            '(FRA) Sud-Ouest',
        );

        $areas = array(
            '(FRA) Alsace',
            '(FRA) Auvergne',
            '(FRA) Beaujolais',
            '(FRA) Bordeaux area',
            '(FRA) Burgundy',
            '(FRA) Centre',
            '(FRA) Champagne',
            '(FRA) Corsica',
            '(FRA) Jura',
            '(FRA) Languedoc',
            '(FRA) Loire',
            '(FRA) Provence',
            '(FRA) Roussillon',
            '(FRA) Savoy',
            '(FRA) Southwest',
        );

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($areas as $i => $area) {
            $winemakerarea[$i] = new WmkrArea();
            $winemakerarea[$i]->setArea($area);

            $repository->translate($winemakerarea[$i], 'area', 'fr', $areasfr[$i]);

            $manager->persist($winemakerarea[$i]);

            $this->addReference('winemakerarea-'.$i, $winemakerarea[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 401; // l'ordre dans lequel les fichiers sont chargés
    }
}
