<?php
// src/FBN/GuideBundle/DataFixtures/ORM/ImageTutorielChapitreParaVinNaturel.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageTutorielChapitreParaVinNaturel extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $rangs = array(0,0,0,0);

        $chemin = __DIR__.'/../../../../../web/uploads/images/tutoriels';

        $noms = array('tutoriel-le-vin-au-naturel-c0-p0-i0.jpg','tutoriel-le-vin-au-naturel-c1-p1-i1.jpg','tutoriel-le-vin-au-naturel-c2-p2-i2.jpg','tutoriel-le-vin-au-naturel-c3-p3-i3.jpg');

        $tailles = array(114688,40960,45056,49152);

        $mimetype = 'image/jpeg';

        $legendes = array('Le terroir','C\'est quoi un vin naturel ?','Les vins bio','La viticulture biodynamique');        

        $legendesen = array('The terroir','What is a natural wine?','Organic wines','Biodynamic viticulture');        

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

            $this->addReference('imagetutorielchapitreparavinnaturel-' . $i, $imagetutoriel[$i]);            
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 106; // l'ordre dans lequel les fichiers sont chargés
    }  
}