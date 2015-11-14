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
    
        $ranks = array(0, 0, 0, 0, 0);

        $path = __DIR__.'/../../../../../web/uploads/images/restaurants';

        $names = array('restaurant-paris-triplettes-il.jpg', 'restaurant-paris-naturellement-il.jpg', 'restaurant-paris-la-fine-mousse-il.jpg', 'restaurant-paris-dix-huit-il.jpg', 'restaurant-paris-cantine-california-il.jpg');

        $sizes = array(73797, 78427, 78651, 83717, 66449);

        $mimetype = 'image/jpeg';

        $legends = array('Plutôt trois fois qu\'une', 'Nature, quoi d\'autre ?', 'So bière!', '18 (dix-huit)', 'Si tu viens to San Fransisco...');        

        $legendsen = array('Three times better than one', 'Nature, what else ?', 'So beer!', '18 (eigtheen)', 'If you come to San Fransisco...');        

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');        

        foreach($ranks as $i => $rank)
        {
            $imagerestaurant[$i] = new Image();
            $imagerestaurant[$i]->setRank($rank);                        
        }

        foreach($names as $i => $name)
        {            
            $imagerestaurant[$i]->setPath($path);
            $imagerestaurant[$i]->setName($name);                        
        }

        foreach($sizes as $i => $size)
        {
            $imagerestaurant[$i]->setSize($size);
            $imagerestaurant[$i]->setMimeType($mimetype);                        
        }

        foreach($legends as $i => $legend)
        {
            $imagerestaurant[$i]->setLegend($legend);

            $repository->translate($imagerestaurant[$i], 'legend', 'en', $legendsen[$i]);             
            
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