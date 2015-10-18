<?php
// src/FBN/GuideBundle/DataFixtures/ORM/ImageTutorielChapitreParaMacerationCarbonique.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageTutorielChapitreParaMacerationCarbonique extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $rangs = array(0,0,0);

        $chemin = __DIR__.'/../../../../../web/uploads/images/tutoriels';

        $noms = array('tutoriel-la-maceration-carbonique-c0-p0-i0.jpg','tutoriel-la-maceration-carbonique-c1-p0-i0.jpg','tutoriel-la-maceration-carbonique-c2-p0-i0.jpg');

        $tailles = array(53248,86016,53248);

        $mimetype = 'image/jpeg';

        $legendes = array('Théorie','Mise en œuvre','Produits obtenus');        

        $legendesen = array('Theory','Implementation','Products obtained');        

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');        

        foreach($rangs as $i => $rang)
        {
            $imagetutoriel[$i] = new Image();
            $imagetutoriel[$i]->setRang($rang);                        
        }

        foreach($noms as $i => $nom)
        {            
            $imagetutoriel[$i]->setChemin($chemin);
            $imagetutoriel[$i]->setNom($nom);                        
        }

        foreach($tailles as $i => $taille)
        {
            $imagetutoriel[$i]->setTaille($taille);
            $imagetutoriel[$i]->setMimeType($mimetype);                        
        }

        foreach($legendes as $i => $legende)
        {
            $imagetutoriel[$i]->setLegende($legende);

            $repository->translate($imagetutoriel[$i], 'legende', 'en', $legendesen[$i]);             
            
            $manager->persist($imagetutoriel[$i]);

            $imagetutoriel[$i]->setImageType($this->getReference('imagetype-0'));

            $this->addReference('imagetutorielchapitreparamacerationcarbonique-' . $i, $imagetutoriel[$i]);            
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 109; // l'ordre dans lequel les fichiers sont chargés
    }  
}