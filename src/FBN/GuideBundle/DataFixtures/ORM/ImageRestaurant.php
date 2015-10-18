<?php
// src/FBN/GuideBundle/DataFixtures/ORM/ImageRestaurant.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageRestaurant extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $rangs = array(0, 0, 0, 0, 0);

        $chemin = __DIR__.'/../../../../../web/uploads/images/restaurants';

        $noms = array('restaurant-paris-triplettes-il.jpg', 'restaurant-paris-naturellement-il.jpg', 'restaurant-paris-la-fine-mousse-il.jpg', 'restaurant-paris-dix-huit-il.jpg', 'restaurant-paris-cantine-california-il.jpg');

        $tailles = array(73797, 78427, 78651, 83717, 66449);

        $mimetype = 'image/jpeg';

        $legendes = array('Plutôt trois fois qu\'une', 'Nature, quoi d\'autre ?', 'So bière!', '18 (dix-huit)', 'Si tu viens to San Fransisco...');        

        $legendesen = array('Three times better than one', 'Nature, what else ?', 'So beer!', '18 (eigtheen)', 'If you come to San Fransisco...');        

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');        

        foreach($rangs as $i => $rang)
        {
            $imagerestaurant[$i] = new Image();
            $imagerestaurant[$i]->setRang($rang);                        
        }

        foreach($noms as $i => $nom)
        {            
            $imagerestaurant[$i]->setChemin($chemin);
            $imagerestaurant[$i]->setNom($nom);                        
        }

        foreach($tailles as $i => $taille)
        {
            $imagerestaurant[$i]->setTaille($taille);
            $imagerestaurant[$i]->setMimeType($mimetype);                        
        }

        foreach($legendes as $i => $legende)
        {
            $imagerestaurant[$i]->setLegende($legende);

            $repository->translate($imagerestaurant[$i], 'legende', 'en', $legendesen[$i]);             
            
            $manager->persist($imagerestaurant[$i]);

            $this->addReference('imagerestaurant-' . $i, $imagerestaurant[$i]);

            $imagerestaurant[$i]->setImageType($this->getReference('imagetype-0'));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 102; // l'ordre dans lequel les fichiers sont chargés
    }  
}