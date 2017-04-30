<?php

namespace FBN\GuideBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorialChapter as TutoChapter;

class TutorialChapterBiodynamics extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $titlesfr = array('Les buts de l’agriculture biodynamique', 'Historique de l’agriculture biodynamique en France', 'Les vins bio');

        $ranks = array(0, 1, 2);

        $titles = array('The goals of biodynamic agriculture', 'History biodynamic agriculture in France', 'Organic wines');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutorial_ids = array(
            2,
            2,
            2,
            2,
            );

        foreach ($titles as $i => $title) {
            $tutorialchapter[$i] = new TutoChapter();
            $tutorialchapter[$i]->setTitle($title);
            $repository->translate($tutorialchapter[$i], 'title', 'fr', $titlesfr[$i]);
        }

        foreach ($ranks as $i => $rank) {
            $tutorialchapter[$i]->setRank($rank);

            $manager->persist($tutorialchapter[$i]);

            $this->addReference('tutorialchapterbiodynamie-'.$i, $tutorialchapter[$i]);

            $tutorialchapter[$i]->setTutorial($this->getReference('tutorial-'.($tutorial_ids[$i] - 1)));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 712;
    }
}
