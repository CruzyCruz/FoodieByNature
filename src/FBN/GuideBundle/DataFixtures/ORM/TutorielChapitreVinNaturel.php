<?php
// src/FBN/GuideBundle/DataFixtures/ORM/TutorielChapitreVinNaturel.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorielChapitre as TutoChapitre;

class TutorielChapitreVinNaturel extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $titres = array('Le terroir', 'C\'est quoi un vin naturel ?', 'Les vins bio', 'La viticulture biodynamique');        

        $rangs = array(0, 1, 2, 3);

        $titresen = array('The terroir', 'What is a natural wine?', 'Organic wines', 'Biodynamic viticulture');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutoriel_ids = array(
            1,
            1,
            1,
            1
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

            $this->addReference('tutorielchapitrevinnaturel-' . $i, $tutorielchapitre[$i]); 

            $tutorielchapitre[$i]->setTutoriel($this->getReference('tutoriel-' . ($tutoriel_ids[$i]-1)));             
                          
        }              
            
        $manager->flush();
    }

    public function getOrder()
    {
        return 703; // l'ordre dans lequel les fichiers sont chargés
    }
}