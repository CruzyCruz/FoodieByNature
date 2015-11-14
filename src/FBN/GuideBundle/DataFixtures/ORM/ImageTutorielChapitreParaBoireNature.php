<?php
// src/FBN/GuideBundle/DataFixtures/ORM/ImageTutorielChapitreParaBoireNature.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageTutorielChapitreParaBoireNature extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $ranks = array(0,0,0,0,0);

        $path = __DIR__.'/../../../../../web/uploads/images/tutoriels';

        $names = array('tutoriel-boire-nature-c0-p0-i0.jpg','tutoriel-boire-nature-c1-p0-i0.jpg','tutoriel-boire-nature-c1-p1-i0.jpg','tutoriel-boire-nature-c1-p2-i0.jpg','tutoriel-boire-nature-c2-p0-i0.jpg');

        $sizes = array(118784,86016,28672,69632,77824);

        $mimetype = 'image/jpeg';

        $legends = array('Des vins vivants','Des vins détendus #0','Des vins détendus #1','Des vins détendus #2','Classsique vs Naturel');        

        $legendsen = array('Alive wines','Relaxed Wines #0','Relaxed Wines #1','Relaxed Wines #2','Classic vs Natural');        

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');        

        foreach($ranks as $i => $rank)
        {
            $imagetutoriel[$i] = new Image();
            $imagetutoriel[$i]->setRank($rank);                        
        }

        foreach($names as $i => $name)
        {            
            $imagetutoriel[$i]->setPath($path);
            $imagetutoriel[$i]->setName($name);                        
        }

        foreach($sizes as $i => $size)
        {
            $imagetutoriel[$i]->setSize($size);
            $imagetutoriel[$i]->setMimeType($mimetype);                        
        }

        foreach($legends as $i => $legend)
        {
            $imagetutoriel[$i]->setLegend($legend);

            $repository->translate($imagetutoriel[$i], 'legend', 'en', $legendsen[$i]);             
            
            $manager->persist($imagetutoriel[$i]);

            $imagetutoriel[$i]->setImageType($this->getReference('imagetype-0'));

            $this->addReference('imagetutorielchapitreparaboirenature-' . $i, $imagetutoriel[$i]);            
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 110; // l'ordre dans lequel les fichiers sont chargés
    }  
}