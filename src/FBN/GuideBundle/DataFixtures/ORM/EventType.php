<?php

// src/FBN/GuideBundle/DataFixtures/ORM/EventType.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\EventType as EvtType;

class EventType extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $typesfr = array('Rencontres vignerones', 'Salon', 'Exposition', 'Repas');

        $types = array('Winegrowers meeting', 'Show', 'Exhibit', 'Meal');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($types as $i => $type) {
            $eventtype[$i] = new EvtType();
            $eventtype[$i]->setType($type);

            $repository->translate($eventtype[$i], 'type', 'fr', $typesfr[$i]);

            $manager->persist($eventtype[$i]);

            $this->addReference('eventtype-'.$i, $eventtype[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 501; // l'ordre dans lequel les fichiers sont chargés
    }
}
