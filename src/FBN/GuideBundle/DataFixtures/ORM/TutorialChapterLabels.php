<?php

// src/FBN/GuideBundle/DataFixtures/ORM/TutorialChapterLabels.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorialChapter as TutoChapter;

class TutorialChapterLabels extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $titres = array('AB, le B.A BA du bio', 'Bio cohérence, plus bio que bio', 'Nature et Progrès, des fermes 100% bio');

        $ranks = array(0, 1, 2);

        $titresen = array('AB, BA B.A the organic', 'Bio consistency, more organic than organic', 'Nature and Progress, 100% organic farms');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutoriel_ids = array(
            3,
            3,
            3,
            3,
            );

        foreach ($titres as $i => $titre) {
            $tutorialchapter[$i] = new TutoChapter();
            $tutorialchapter[$i]->setTitre($titre);
            $repository->translate($tutorialchapter[$i], 'titre', 'en', $titresen[$i]);
        }

        foreach ($ranks as $i => $rank) {
            $tutorialchapter[$i]->setRank($rank);

            $manager->persist($tutorialchapter[$i]);

            $this->addReference('tutorialchapterlabels-'.$i, $tutorialchapter[$i]);

            $tutorialchapter[$i]->setTutoriel($this->getReference('tutoriel-'.($tutoriel_ids[$i] - 1)));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 722; // l'ordre dans lequel les fichiers sont chargés
    }
}
