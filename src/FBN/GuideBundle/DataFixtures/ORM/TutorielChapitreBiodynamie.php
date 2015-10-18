<?php
// src/FBN/GuideBundle/DataFixtures/ORM/TutorielChapitreBiodynamie.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorielChapitre as TutoChapitre;

class TutorielChapitreBiodynamie extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $titres = array('Les buts de l’agriculture biodynamique', 'Historique de l’agriculture biodynamique en France', 'Historique de l’agriculture biodynamique dans le monde');        

        $rangs = array(0, 1, 2);

        $titresen = array('The goals of biodynamic agriculture', 'History biodynamic agriculture in France', 'Organic wines', 'History biodynamic agriculture in the world');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutoriel_ids = array(
            2,
            2,
            2,
            2
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

            $this->addReference('tutorielchapitrebiodynamie-' . $i, $tutorielchapitre[$i]); 

            $tutorielchapitre[$i]->setTutoriel($this->getReference('tutoriel-' . ($tutoriel_ids[$i]-1)));             
                          
        }              
            
        $manager->flush();
    }

    public function getOrder()
    {
        return 712; // l'ordre dans lequel les fichiers sont chargés
    }
}