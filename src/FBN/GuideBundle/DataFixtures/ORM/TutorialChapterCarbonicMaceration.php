<?php

namespace FBN\GuideBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorialChapter as TutoChapter;

class TutorialChapterCarbonicMaceration extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $titlesfr = array('Théorie', 'Mise en œuvre', 'Produits obtenus');

        $ranks = array(0, 1, 2);

        $titles = array('Theory', 'Implementation', 'Products obtained');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutorial_ids = array(
            4,
            4,
            4,
            4,
            );

        foreach ($titles as $i => $title) {
            $tutorialchapter[$i] = new TutoChapter();
            $tutorialchapter[$i]->setTitle($title);
            $repository->translate($tutorialchapter[$i], 'title', 'fr', $titlesfr[$i]);
        }

        foreach ($ranks as $i => $rank) {
            $tutorialchapter[$i]->setRank($rank);

            $manager->persist($tutorialchapter[$i]);

            $this->addReference('tutorialchaptermacerationcarbonique-'.$i, $tutorialchapter[$i]);

            $tutorialchapter[$i]->setTutorial($this->getReference('tutorial-'.($tutorial_ids[$i] - 1)));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 732;
    }
}
