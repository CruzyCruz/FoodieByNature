<?php
// src/FBN/GuideBundle/DataFixtures/ORM/ImageVigneron.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageVigneron extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $ranks = array(0, 0, 0, 0, 0);

        $chemin = __DIR__.'/../../../../../web/uploads/images/vignerons';

        $noms = array('vigneron-didier-barral-il.jpg', 'vigneron-marcel-lapierre-il.jpg', 'vigneron-elian-da-ros-il.jpg', 'vigneron-robert-plageoles-il.jpg', 'vigneron-jacques-selosse-il.jpg');

        $tailles = array(31111, 73088, 76454, 55682, 27758);

        $mimetype = 'image/jpeg';

        $legendes = array('Oui Didier!', 'RIP Marcel!', 'Da Da Da!', 'Roberto mio palmo!', 'The Jacky touch!');        

        $legendesen = array('Yes Didier!', 'RIP Marcel!', 'Da Da Da!', 'Roberto mio palmo!', 'The Jacky touch!');        

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');        

        foreach($ranks as $i => $rank)
        {
            $imagerestaurant[$i] = new Image();
            $imagerestaurant[$i]->setRank($rank);                        
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

            $this->addReference('imagevigneron-' . $i, $imagerestaurant[$i]);

            $imagerestaurant[$i]->setImageType($this->getReference('imagetype-0'));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 103; // l'ordre dans lequel les fichiers sont chargés
    }  
}