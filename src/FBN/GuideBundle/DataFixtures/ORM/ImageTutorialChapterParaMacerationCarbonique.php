<?php

// src/FBN/GuideBundle/DataFixtures/ORM/ImageTutorialChapterParaMacerationCarbonique.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageTutorialChapterParaMacerationCarbonique extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $ranks = array(0,0,0);

        $path = __DIR__.'/../../../../../web/uploads/images/tutorials';

        $names = array('tutorial-la-maceration-carbonique-c0-p0-i0.jpg','tutorial-la-maceration-carbonique-c1-p0-i0.jpg','tutorial-la-maceration-carbonique-c2-p0-i0.jpg');

        $sizes = array(53248,86016,53248);

        $mimetype = 'image/jpeg';

        $legends = array('Théorie','Mise en œuvre','Produits obtenus');

        $legendsen = array('Theory','Implementation','Products obtained');

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

            $this->addReference('imagetutorialchapterparamacerationcarbonique-'.$i, $imagetutorial[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 109; // l'ordre dans lequel les fichiers sont chargés
    }
}
