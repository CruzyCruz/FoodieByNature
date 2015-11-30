<?php

// src/FBN/GuideBundle/DataFixtures/ORM/TutorialChapterBiodynamie.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorialChapter as TutoChapter;

class TutorialChapterBiodynamie extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $titles = array('Les buts de l’agriculture biodynamique', 'Historique de l’agriculture biodynamique en France', 'Historique de l’agriculture biodynamique dans le monde');

        $ranks = array(0, 1, 2);

        $titlesen = array('The goals of biodynamic agriculture', 'History biodynamic agriculture in France', 'Organic wines', 'History biodynamic agriculture in the world');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutoriel_ids = array(
            2,
            2,
            2,
            2,
            );

        foreach ($titles as $i => $title) {
            $tutorialchapter[$i] = new TutoChapter();
            $tutorialchapter[$i]->setTitle($title);
            $repository->translate($tutorialchapter[$i], 'title', 'en', $titlesen[$i]);
        }

        foreach ($ranks as $i => $rank) {
            $tutorialchapter[$i]->setRank($rank);

            $manager->persist($tutorialchapter[$i]);

            $this->addReference('tutorialchapterbiodynamie-'.$i, $tutorialchapter[$i]);

            $tutorialchapter[$i]->setTutoriel($this->getReference('tutoriel-'.($tutoriel_ids[$i] - 1)));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 712; // l'ordre dans lequel les fichiers sont chargés
    }
}
