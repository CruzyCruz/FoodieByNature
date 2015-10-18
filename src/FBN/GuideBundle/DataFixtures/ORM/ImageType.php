<?php
// src/FBN/GuideBundle/DataFixtures/ORM/ImageType.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\ImageType as ImgType;

class ImageType extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $types = array('Illustration', 'CV');             

        foreach($types as $i => $type)
        {
            $imagetype[$i] = new ImgType();
            $imagetype[$i]->setType($type);
            $manager->persist($imagetype[$i]);

            $this->addReference('imagetype-' . $i, $imagetype[$i]);
        }   

        $manager->flush();
    }

    public function getOrder()
    {
        return 101; // l'ordre dans lequel les fichiers sont chargés
    }  
}