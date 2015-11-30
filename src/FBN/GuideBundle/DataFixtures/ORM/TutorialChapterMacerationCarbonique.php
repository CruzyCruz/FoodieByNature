<?php

// src/FBN/GuideBundle/DataFixtures/ORM/TutorialChapterMacerationCarbonique.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorialChapter as TutoChapter;

class TutorialChapterMacerationCarbonique extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $titles = array('Théorie', 'Mise en œuvre', 'Produits obtenus');

        $ranks = array(0, 1, 2);

        $titlesen = array('Theory', 'Implementation', 'Products obtained');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutoriel_ids = array(
            4,
            4,
            4,
            4,
            );

        foreach ($titles as $i => $title) {
            $tutorialchapter[$i] = new TutoChapter();
            $tutorialchapter[$i]->setTitle($title);
            $repository->translate($tutorialchapter[$i], 'title', 'en', $titlesen[$i]);
        }

        foreach ($ranks as $i => $rank) {
            $tutorialchapter[$i]->setRank($rank);

            $manager->persist($tutorialchapter[$i]);

            $this->addReference('tutorialchaptermacerationcarbonique-'.$i, $tutorialchapter[$i]);

            $tutorialchapter[$i]->setTutoriel($this->getReference('tutoriel-'.($tutoriel_ids[$i] - 1)));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 732; // l'ordre dans lequel les fichiers sont chargés
    }
}
