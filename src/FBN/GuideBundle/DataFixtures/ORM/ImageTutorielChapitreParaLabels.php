<?php
// src/FBN/GuideBundle/DataFixtures/ORM/ImageTutorielChapitreParaLabels.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageTutorielChapitreParaLabels extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $ranks = array(0,0,0);

        $path = __DIR__.'/../../../../../web/uploads/images/tutoriels';

        $names = array('tutoriel-les-labels-c0-p0-i0.jpg','tutoriel-les-labels-c1-p0-i0.jpg','tutoriel-les-labels-c2-p0-i0.jpg');

        $sizes = array(61440,49152,61440);

        $mimetype = 'image/jpeg';

        $legendes = array('AB, le B.A BA du bio','Bio cohérence, plus bio que bio','Nature et Progrès, des fermes 100% bio');        

        $legendesen = array('AB, BA B.A the organic','Bio consistency, more organic than organic','Nature and Progress, 100% organic farms');        

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

        foreach($legendes as $i => $legende)
        {
            $imagetutoriel[$i]->setLegende($legende);

            $repository->translate($imagetutoriel[$i], 'legende', 'en', $legendesen[$i]);             
            
            $manager->persist($imagetutoriel[$i]);

            $imagetutoriel[$i]->setImageType($this->getReference('imagetype-0'));

            $this->addReference('imagetutorielchapitreparalabels-' . $i, $imagetutoriel[$i]);            
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 108; // l'ordre dans lequel les fichiers sont chargés
    }  
}