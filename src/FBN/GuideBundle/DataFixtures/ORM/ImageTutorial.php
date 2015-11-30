<?php

// src/FBN/GuideBundle/DataFixtures/ORM/ImageTutorial.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageTutorial extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $ranks = array(0,0,0,0,0);

        $path = __DIR__.'/../../../../../web/uploads/images/tutorials';

        $names = array('tutorial-le-vin-au-naturel.jpg','tutorial-la-biodynamie.jpg','tutorial-les-labels.jpg','tutorial-la-maceration-carbonique.jpg','tutorial-boire-nature.jpg');

        $sizes = array(65536,69632,90112,40960,69632);

        $mimetype = 'image/jpeg';

        $legends = array('Le vin au naturel','La biodynamie','Les labels','La macération carbonique','Boire nature');

        $legendsen = array('Natural Wine','Biodynamics','Labels','Carbonic maceration','Drink nature');

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

            $this->addReference('imagetutorial-'.$i, $imagetutorial[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 105; // l'ordre dans lequel les fichiers sont chargés
    }
}
