<?php
// src/FBN/GuideBundle/DataFixtures/ORM/TutorielRubrique.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorielRubrique as TutoRubrique;

class TutorielRubrique extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $rubriques = array('Comprendre', 'Boire', 'Faire');       

        $rubriquesen = array('Understand', 'Drink', 'Make');   

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach($rubriques as $i => $rubrique)
        {
            $tutorielrubrique[$i] = new TutoRubrique();
            $tutorielrubrique[$i]->setRubrique($rubrique); 
            $repository->translate($tutorielrubrique[$i], 'rubrique', 'en', $rubriquesen[$i]);   

            $this->addReference('tutorielrubrique-' . $i, $tutorielrubrique[$i]);  
        }             
            
        $manager->flush();
    }

    public function getOrder()
    {
        return 701; // l'ordre dans lequel les fichiers sont chargés
    }
}