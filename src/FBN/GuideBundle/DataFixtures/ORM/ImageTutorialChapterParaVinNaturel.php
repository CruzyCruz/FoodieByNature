<?php

// src/FBN/GuideBundle/DataFixtures/ORM/ImageTutorialChapterParaVinNaturel.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageTutorialChapterParaVinNaturel extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $ranks = array(0,0,0,0);

        $path = __DIR__.'/../../../../../web/uploads/images/tutorials';

        $names = array('tutorial-le-vin-au-naturel-c0-p0-i0.jpg','tutorial-le-vin-au-naturel-c1-p1-i1.jpg','tutorial-le-vin-au-naturel-c2-p2-i2.jpg','tutorial-le-vin-au-naturel-c3-p3-i3.jpg');

        $sizes = array(114688,40960,45056,49152);

        $mimetype = 'image/jpeg';

        $legends = array('Le terroir','C\'est quoi un vin naturel ?','Les vins bio','La viticulture biodynamique');

        $legendsen = array('The terroir','What is a natural wine?','Organic wines','Biodynamic viticulture');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($ranks as $i => $rank) {
            $imagetutorial[$i] = new Image();
            $imagetutorial[$i]->setRank($rank);
        }

        foreach ($names as $i => $name) {
            $imagetutorial[$i]->setPath($path);
            $imagetutorial[$i]->setName($name);
        }

        foreach ($sizes as $i => $size) {
            $imagetutorial[$i]->setSize($size);
            $imagetutorial[$i]->setMimeType($mimetype);
        }

        foreach ($legends as $i => $legend) {
            $imagetutorial[$i]->setLegend($legend);

            $repository->translate($imagetutorial[$i], 'legend', 'en', $legendsen[$i]);

            $manager->persist($imagetutorial[$i]);

            $imagetutorial[$i]->setImageType($this->getReference('imagetype-0'));

            $this->addReference('imagetutorialchapterparavinnaturel-'.$i, $imagetutorial[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 106; // l'ordre dans lequel les fichiers sont chargés
    }
}
