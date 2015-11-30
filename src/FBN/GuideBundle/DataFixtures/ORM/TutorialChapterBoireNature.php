<?php

// src/FBN/GuideBundle/DataFixtures/ORM/TutorialChapterBoireNature.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorialChapter as TutoChapter;

class TutorialChapterBoireNature extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $titles = array('Des vins vivants', 'Des vins détendus', 'Classsique vs Naturel');

        $ranks = array(0, 1, 2);

        $titlesen = array('Alive wines', 'Relaxed Wines', 'Classic vs Natural');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutorial_ids = array(
            5,
            5,
            5,
            5,
            );

        foreach ($titles as $i => $title) {
            $tutorialchapter[$i] = new TutoChapter();
            $tutorialchapter[$i]->setTitle($title);
            $repository->translate($tutorialchapter[$i], 'title', 'en', $titlesen[$i]);
        }

        foreach ($ranks as $i => $rank) {
            $tutorialchapter[$i]->setRank($rank);

            $manager->persist($tutorialchapter[$i]);

            $this->addReference('tutorialchapterboirenature-'.$i, $tutorialchapter[$i]);

            $tutorialchapter[$i]->setTutorial($this->getReference('tutorial-'.($tutorial_ids[$i] - 1)));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 742; // l'ordre dans lequel les fichiers sont chargés
    }
}
