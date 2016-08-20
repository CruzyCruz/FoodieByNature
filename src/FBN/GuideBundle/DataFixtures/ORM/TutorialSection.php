<?php

// src/FBN/GuideBundle/DataFixtures/ORM/TutorialSection.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorialSection as TutoSection;

class TutorialSection extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $sectionsfr = array('Comprendre', 'Boire', 'Faire');

        $sections = array('Understand', 'Drink', 'Make');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($sections as $i => $section) {
            $tutorialsection[$i] = new TutoSection();
            $tutorialsection[$i]->setSection($section);
            $repository->translate($tutorialsection[$i], 'section', 'fr', $sectionsfr[$i]);

            $this->addReference('tutorialsection-'.$i, $tutorialsection[$i]);

            $manager->persist($tutorialsection[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 701; // l'ordre dans lequel les fichiers sont chargés
    }
}
