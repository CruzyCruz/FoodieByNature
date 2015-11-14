<?php
// src/FBN/GuideBundle/DataFixtures/ORM/TutorielChapitreLabels.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorielChapitre as TutoChapitre;

class TutorielChapitreLabels extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $titres = array('AB, le B.A BA du bio', 'Bio cohérence, plus bio que bio', 'Nature et Progrès, des fermes 100% bio');

        $ranks = array(0, 1, 2);

        $titresen = array('AB, BA B.A the organic', 'Bio consistency, more organic than organic', 'Nature and Progress, 100% organic farms');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutoriel_ids = array(
            3,
            3,
            3,
            3
            );                

        foreach($titres as $i => $titre)
        {
            $tutorielchapitre[$i] = new TutoChapitre();
            $tutorielchapitre[$i]->setTitre($titre); 
            $repository->translate($tutorielchapitre[$i], 'titre', 'en', $titresen[$i]);           
        }             

        foreach($ranks as $i => $rank)
        {
            $tutorielchapitre[$i]->setRank($rank);  

            $manager->persist($tutorielchapitre[$i]);  

            $this->addReference('tutorielchapitrelabels-' . $i, $tutorielchapitre[$i]); 

            $tutorielchapitre[$i]->setTutoriel($this->getReference('tutoriel-' . ($tutoriel_ids[$i]-1)));             
                          
        }              
            
        $manager->flush();
    }

    public function getOrder()
    {
        return 722; // l'ordre dans lequel les fichiers sont chargés
    }
}