<?php

// src/FBN/GuideBundle/DataFixtures/ORM/ImageWinemaker.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageWinemaker extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $ranks = array(0, 0, 0, 0, 0);

        $path = __DIR__.'/../../../../../web/uploads/images/winemakers';

        $names = array('winemaker-didier-barral-il.jpg', 'winemaker-marcel-lapierre-il.jpg', 'winemaker-elian-da-ros-il.jpg', 'winemaker-robert-plageoles-il.jpg', 'winemaker-jacques-selosse-il.jpg');

        $sizes = array(31111, 73088, 76454, 55682, 27758);

        $mimetype = 'image/jpeg';

        $legends = array('Oui Didier!', 'RIP Marcel!', 'Da Da Da!', 'Roberto mio palmo!', 'The Jacky touch!');

        $legendsen = array('Yes Didier!', 'RIP Marcel!', 'Da Da Da!', 'Roberto mio palmo!', 'The Jacky touch!');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($ranks as $i => $rank) {
            $imagerestaurant[$i] = new Image();
            $imagerestaurant[$i]->setRank($rank);
        }

        foreach ($names as $i => $name) {
            $imagerestaurant[$i]->setPath($path);
            $imagerestaurant[$i]->setName($name);
        }

        foreach ($sizes as $i => $size) {
            $imagerestaurant[$i]->setSize($size);
            $imagerestaurant[$i]->setMimeType($mimetype);
        }

        foreach ($legends as $i => $legend) {
            $imagerestaurant[$i]->setLegend($legend);

            $repository->translate($imagerestaurant[$i], 'legend', 'en', $legendsen[$i]);

            $manager->persist($imagerestaurant[$i]);

            $this->addReference('imagewinemaker-'.$i, $imagerestaurant[$i]);

            $imagerestaurant[$i]->setImageType($this->getReference('imagetype-0'));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 103; // l'ordre dans lequel les fichiers sont chargés
    }
}
