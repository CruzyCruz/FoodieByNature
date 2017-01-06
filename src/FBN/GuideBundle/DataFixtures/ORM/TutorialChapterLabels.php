<?php

namespace FBN\GuideBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorialChapter as TutoChapter;

class TutorialChapterLabels extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $titlesfr = array('AB, le B.A BA du bio', 'Bio cohérence, plus bio que bio', 'Nature et Progrès, des fermes 100% bio');

        $ranks = array(0, 1, 2);

        $titles = array('AB, BA B.A the organic', 'Bio consistency, more organic than organic', 'Nature and Progress, 100% organic farms');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutorial_ids = array(
            3,
            3,
            3,
            3,
            );

        foreach ($titles as $i => $title) {
            $tutorialchapter[$i] = new TutoChapter();
            $tutorialchapter[$i]->setTitle($title);
            $repository->translate($tutorialchapter[$i], 'title', 'fr', $titlesfr[$i]);
        }

        foreach ($ranks as $i => $rank) {
            $tutorialchapter[$i]->setRank($rank);

            $manager->persist($tutorialchapter[$i]);

            $this->addReference('tutorialchapterlabels-'.$i, $tutorialchapter[$i]);

            $tutorialchapter[$i]->setTutorial($this->getReference('tutorial-'.($tutorial_ids[$i] - 1)));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 722;
    }
}
