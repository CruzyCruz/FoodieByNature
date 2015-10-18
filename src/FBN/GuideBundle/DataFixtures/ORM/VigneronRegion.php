<?php
// src/FBN/GuideBundle/DataFixtures/ORM/VigneronRegion.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\VigneronRegion as VRegion;

class VigneronRegion extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $regions = array(
            'Alsace',
            'Auvergne',            
            'Beaujolais',            
            'Bordelais',
            'Bourgogne',
            'Centre',
            'Champagne',
            'Corse',
            'Jura',
            'Languedoc',
            'Loire',
            'Provence',
            'Roussillon',
            'Savoie',
            'Sud-Ouest',
        );     

        $regionsen = array(
            'Alsace',
            'Auvergne',            
            'Beaujolais',            
            'Bordeaux area',
            'Burgundy',
            'Centre',
            'Champagne',
            'Corsica',
            'Jura',
            'Languedoc',
            'Loire',
            'Provence',
            'Roussillon',
            'Savoy',
            'Southwest',
        );    

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');                

        foreach($regions as $i => $region)
        {
            $vigneronregion[$i] = new VRegion();
            $vigneronregion[$i]->setRegion($region);

            $repository->translate($vigneronregion[$i], 'region', 'en', $regionsen[$i]); 

            $manager->persist($vigneronregion[$i]);

            $this->addReference('vigneronregion-' . $i, $vigneronregion[$i]);
        }   

        $manager->flush();
    }

    public function getOrder()
    {
        return 401; // l'ordre dans lequel les fichiers sont chargés
    }  
}