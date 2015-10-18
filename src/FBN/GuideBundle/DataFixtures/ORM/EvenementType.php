<?php
// src/FBN/GuideBundle/DataFixtures/ORM/EvenementType.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\EvenementType as EvtType;

class EvenementType extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $types = array('Rencontres vignerones', 'Salon', 'Exposition', 'Repas');  

        $typesen = array('Winegrowers meeting', 'Show', 'Exhibit', 'Meal');          

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');            

        foreach($types as $i => $type)
        {
            $evenementtype[$i] = new EvtType();
            $evenementtype[$i]->setType($type);

            $repository->translate($evenementtype[$i], 'type', 'en', $typesen[$i]);   

            $manager->persist($evenementtype[$i]);

            $this->addReference('evenementtype-' . $i, $evenementtype[$i]);
        }   

        $manager->flush();
    }

    public function getOrder()
    {
        return 501; // l'ordre dans lequel les fichiers sont chargés
    }  
}