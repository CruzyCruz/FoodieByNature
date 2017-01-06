<?php

namespace FBN\GuideBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorialChapter as TutoChapter;

class TutorialChapterVinNaturel extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $titlesfr = array('Le terroir', 'C\'est quoi un vin naturel ?', 'Les vins bio', 'La viticulture biodynamique');

        $ranks = array(0, 1, 2, 3);

        $titles = array('The terroir', 'What is a natural wine?', 'Organic wines', 'Biodynamic viticulture');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutorial_ids = array(
            1,
            1,
            1,
            1,
            );

        foreach ($titles as $i => $title) {
            $tutorialchapter[$i] = new TutoChapter();
            $tutorialchapter[$i]->setTitle($title);
            $repository->translate($tutorialchapter[$i], 'title', 'fr', $titlesfr[$i]);
        }

        foreach ($ranks as $i => $rank) {
            $tutorialchapter[$i]->setRank($rank);

            $manager->persist($tutorialchapter[$i]);

            $this->addReference('tutorialchaptervinnaturel-'.$i, $tutorialchapter[$i]);

            $tutorialchapter[$i]->setTutorial($this->getReference('tutorial-'.($tutorial_ids[$i] - 1)));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 703;
    }
}
