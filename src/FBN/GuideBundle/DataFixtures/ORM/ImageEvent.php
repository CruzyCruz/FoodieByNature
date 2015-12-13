<?php

// src/FBN/GuideBundle/DataFixtures/ORM/ImageEvent.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageEvent extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $ranks = array(0, 0, 0, 0, 0, 0, 0, 0);

        $path = __DIR__.'/../../../../../web/uploads/images/events';

        $names = array('event-yvon-metras-au-temps-des-vendanges-2013-il.jpg', 'event-repas-gastronomique-a-toulouse-2013-il.jpg', 'event-sous-les-paves-la-vigne-2014-il.jpg', 'event-la-remise-2013-il.jpg', 'event-yvon-metras-au-temps-des-vendanges-2014-il.jpg', 'event-repas-gastronomique-a-toulouse-2014-il.jpg', 'event-la-remise-2014-il.jpg', 'event-dejeuner-sur-l-herbe-chez-robert-plageoles-2014-il.jpg');

        $sizes = array(65536, 69632, 155648, 24576, 32768, 98304, 221184, 196608);

        $mimetype = 'image/jpeg';

        $legends = array('Métras aux Temps des Vendanges!', 'Repas Gastronomique à Toulouse', 'Sous les pavés la vigne', 'La remise', 'Métras aux Temps des Vendanges!', 'Repas Gastronomique à Toulouse', 'La remise', 'Déjeuner sur l\'herbe chez Plageoles');

        $legendsen = array('Métras at Temps des Vendanges!', 'Gourmet meal in Toulouse', 'Sous les pavés la vigne', 'La remise', 'Métras at Temps des Vendanges!', 'Gourmet meal in Toulouse', 'La remise', 'Lunch on grass at Robert Plageoles');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($ranks as $i => $rank) {
            $imageevent[$i] = new Image();
            $imageevent[$i]->setRank($rank);
        }

        foreach ($names as $i => $name) {
            $imageevent[$i]->setPath($path);
            $imageevent[$i]->setName($name);
        }

        foreach ($sizes as $i => $size) {
            $imageevent[$i]->setSize($size);
            $imageevent[$i]->setMimeType($mimetype);
        }

        foreach ($legends as $i => $legend) {
            $imageevent[$i]->setLegend($legend);

            $repository->translate($imageevent[$i], 'legend', 'en', $legendsen[$i]);

            $manager->persist($imageevent[$i]);

            $this->addReference('imageevent-'.$i, $imageevent[$i]);

            $imageevent[$i]->setImageType($this->getReference('imagetype-0'));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 104; // l'ordre dans lequel les fichiers sont chargés
    }
}
