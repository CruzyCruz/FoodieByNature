<?php

// src/FBN/GuideBundle/DataFixtures/ORM/ImageWinemaker.php


namespace FBN\GuideBundle\DataFixtures\ORM;

use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\ImageWinemaker as Image;

class ImageWinemaker extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $ranks = array(0, 0, 0, 0, 0);

        $path = __DIR__.'/../../../../../web/uploads/images-source/winemakers/';
        $pathto = __DIR__.'/../../../../../web/uploads/images/winemakers/';

        $names = array('winemaker-didier-barral-il.jpg', 'winemaker-marcel-lapierre-il.jpg', 'winemaker-elian-da-ros-il.jpg', 'winemaker-robert-plageoles-il.jpg', 'winemaker-jacques-selosse-il.jpg');

        $legends = array('Oui Didier!', 'RIP Marcel!', 'Da Da Da!', 'Roberto mio palmo!', 'The Jacky touch!');

        $legendsen = array('Yes Didier!', 'RIP Marcel!', 'Da Da Da!', 'Roberto mio palmo!', 'The Jacky touch!');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($ranks as $i => $rank) {
            $imagewinemaker[$i] = new Image();
            $imagewinemaker[$i]->setRank($rank);
        }

        foreach ($names as $i => $name) {
            $imagewinemaker[$i]->setName($name);
            copy($path.$name, $pathto.$name);
            $image = new File($pathto.$name);
            $imagewinemaker[$i]->setFile($image);
        }

        foreach ($legends as $i => $legend) {
            $imagewinemaker[$i]->setLegend($legend);

            $repository->translate($imagewinemaker[$i], 'legend', 'en', $legendsen[$i]);

            $manager->persist($imagewinemaker[$i]);

            $this->addReference('imagewinemaker-'.$i, $imagewinemaker[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 103; // l'ordre dans lequel les fichiers sont chargés
    }
}
