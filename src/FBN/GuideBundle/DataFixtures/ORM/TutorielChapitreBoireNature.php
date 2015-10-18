<?php
// src/FBN/GuideBundle/DataFixtures/ORM/TutorielChapitreBoireNature.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorielChapitre as TutoChapitre;

class TutorielChapitreBoireNature extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $titres = array('Des vins vivants', 'Des vins détendus', 'Classsique vs Naturel');        

        $rangs = array(0, 1, 2);

        $titresen = array('Alive wines', 'Relaxed Wines', 'Classic vs Natural');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutoriel_ids = array(
            5,
            5,
            5,
            5
            );                

        foreach($titres as $i => $titre)
        {
            $tutorielchapitre[$i] = new TutoChapitre();
            $tutorielchapitre[$i]->setTitre($titre); 
            $repository->translate($tutorielchapitre[$i], 'titre', 'en', $titresen[$i]);           
        }             

        foreach($rangs as $i => $rang)
        {
            $tutorielchapitre[$i]->setRang($rang);  

            $manager->persist($tutorielchapitre[$i]);  

            $this->addReference('tutorielchapitreboirenature-' . $i, $tutorielchapitre[$i]); 

            $tutorielchapitre[$i]->setTutoriel($this->getReference('tutoriel-' . ($tutoriel_ids[$i]-1)));             
                          
        }              
            
        $manager->flush();
    }

    public function getOrder()
    {
        return 742; // l'ordre dans lequel les fichiers sont chargés
    }
}