<?php

// src/FBN/GuideBundle/DataFixtures/ORM/ImageEvenement.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageEvenement extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $ranks = array(0, 0, 0, 0, 0, 0, 0, 0);

        $path = __DIR__.'/../../../../../web/uploads/images/evenements';

        $names = array('evenement-yvon-metras-au-temps-des-vendanges-2013-il.jpg', 'evenement-repas-gastronomique-a-toulouse-2013-il.jpg', 'evenement-sous-les-paves-la-vigne-2014-il.jpg', 'evenement-la-remise-2013-il.jpg', 'evenement-yvon-metras-au-temps-des-vendanges-2014-il.jpg', 'evenement-repas-gastronomique-a-toulouse-2014-il.jpg', 'evenement-la-remise-2014-il.jpg', 'evenement-dejeuner-sur-l-herbe-chez-robert-plageoles-2014-il.jpg');

        $sizes = array(65536, 69632, 155648, 24576, 32768, 98304, 221184, 196608);

        $mimetype = 'image/jpeg';

        $legends = array('Métras aux Temps des Vendanges!', 'Repas Gastronomique à Toulouse', 'Sous les pavés la vigne', 'La remise', 'Métras aux Temps des Vendanges!', 'Repas Gastronomique à Toulouse', 'La remise', 'Déjeuner sur l\'herbe chez Plageoles');

        $legendsen = array('Métras at Temps des Vendanges!', 'Gourmet meal in Toulouse', 'Sous les pavés la vigne', 'La remise', 'Métras at Temps des Vendanges!', 'Gourmet meal in Toulouse', 'La remise', 'Lunch on grass at Robert Plageoles');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($ranks as $i => $rank) {
            $imageevenement[$i] = new Image();
            $imageevenement[$i]->setRank($rank);
        }

        foreach ($names as $i => $name) {
            $imageevenement[$i]->setPath($path);
            $imageevenement[$i]->setName($name);
        }

        foreach ($sizes as $i => $size) {
            $imageevenement[$i]->setSize($size);
            $imageevenement[$i]->setMimeType($mimetype);
        }

        foreach ($legends as $i => $legend) {
            $imageevenement[$i]->setLegend($legend);

            $repository->translate($imageevenement[$i], 'legend', 'en', $legendsen[$i]);

            $manager->persist($imageevenement[$i]);

            $this->addReference('imageevenement-'.$i, $imageevenement[$i]);

            $imageevenement[$i]->setImageType($this->getReference('imagetype-0'));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 104; // l'ordre dans lequel les fichiers sont chargés
    }
}
