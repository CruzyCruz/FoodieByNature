<?php
// src/FBN/GuideBundle/DataFixtures/ORM/ImageTutoriel.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageTutoriel extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $ranks = array(0,0,0,0,0);

        $path = __DIR__.'/../../../../../web/uploads/images/tutoriels';

        $noms = array('tutoriel-le-vin-au-naturel.jpg','tutoriel-la-biodynamie.jpg','tutoriel-les-labels.jpg','tutoriel-la-maceration-carbonique.jpg','tutoriel-boire-nature.jpg');

        $tailles = array(65536,69632,90112,40960,69632);

        $mimetype = 'image/jpeg';

        $legendes = array('Le vin au naturel','La biodynamie','Les labels','La macération carbonique','Boire nature');        

        $legendesen = array('Natural Wine','Biodynamics','Labels','Carbonic maceration','Drink nature');        

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');        

        foreach($ranks as $i => $rank)
        {
            $imagetutoriel[$i] = new Image();
            $imagetutoriel[$i]->setRank($rank);                        
        }

        foreach($noms as $i => $nom)
        {            
            $imagetutoriel[$i]->setPath($path);
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

            $this->addReference('imagetutoriel-' . $i, $imagetutoriel[$i]);            
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 105; // l'ordre dans lequel les fichiers sont chargés
    }  
}