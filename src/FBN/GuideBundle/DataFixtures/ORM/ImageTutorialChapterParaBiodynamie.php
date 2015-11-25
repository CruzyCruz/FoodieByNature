<?php

// src/FBN/GuideBundle/DataFixtures/ORM/ImageTutorialChapterParaBiodyamie.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageTutorialChapterParaBiodynamie extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $ranks = array(0,0,0);

        $path = __DIR__.'/../../../../../web/uploads/images/tutoriels';

        $names = array('tutoriel-la-biodynamie-c0-p0-i0.jpg','tutoriel-la-biodynamie-c1-p0-i0.jpg','tutoriel-la-biodynamie-c2-p0-i0.jpg');

        $sizes = array(45056,57344,8192);

        $mimetype = 'image/jpeg';

        $legends = array('Les buts de l’agriculture biodynamique','Historique de l’agriculture biodynamique en France','Historique de l’agriculture biodynamique dans le monde');

        $legendsen = array('The goals of biodynamic agriculture','History biodynamic agriculture in France','Organic wines');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($ranks as $i => $rank) {
            $imagetutoriel[$i] = new Image();
            $imagetutoriel[$i]->setRank($rank);
        }

        foreach ($names as $i => $name) {
            $imagetutoriel[$i]->setPath($path);
            $imagetutoriel[$i]->setName($name);
        }

        foreach ($sizes as $i => $size) {
            $imagetutoriel[$i]->setSize($size);
            $imagetutoriel[$i]->setMimeType($mimetype);
        }

        foreach ($legends as $i => $legend) {
            $imagetutoriel[$i]->setLegend($legend);

            $repository->translate($imagetutoriel[$i], 'legend', 'en', $legendsen[$i]);

            $manager->persist($imagetutoriel[$i]);

            $imagetutoriel[$i]->setImageType($this->getReference('imagetype-0'));

            $this->addReference('imagetutorialchapterparabiodynamie-'.$i, $imagetutoriel[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 107; // l'ordre dans lequel les fichiers sont chargés
    }
}
