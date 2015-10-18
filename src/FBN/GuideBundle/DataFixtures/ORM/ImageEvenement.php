<?php
// src/FBN/GuideBundle/DataFixtures/ORM/ImageEvenement.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Image;

class ImageEvenement extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $rangs = array(0, 0, 0, 0, 0, 0, 0, 0);

        $chemin = __DIR__.'/../../../../../web/uploads/images/evenements';

        $noms = array('evenement-yvon-metras-au-temps-des-vendanges-2013-il.jpg', 'evenement-repas-gastronomique-a-toulouse-2013-il.jpg', 'evenement-sous-les-paves-la-vigne-2014-il.jpg', 'evenement-la-remise-2013-il.jpg', 'evenement-yvon-metras-au-temps-des-vendanges-2014-il.jpg', 'evenement-repas-gastronomique-a-toulouse-2014-il.jpg', 'evenement-la-remise-2014-il.jpg', 'evenement-dejeuner-sur-l-herbe-chez-robert-plageoles-2014-il.jpg');

        $tailles = array(65536, 69632, 155648, 24576, 32768, 98304, 221184, 196608);

        $mimetype = 'image/jpeg';

        $legendes = array('Métras aux Temps des Vendanges!', 'Repas Gastronomique à Toulouse', 'Sous les pavés la vigne', 'La remise', 'Métras aux Temps des Vendanges!', 'Repas Gastronomique à Toulouse', 'La remise', 'Déjeuner sur l\'herbe chez Plageoles');        

        $legendesen = array('Métras at Temps des Vendanges!', 'Gourmet meal in Toulouse', 'Sous les pavés la vigne', 'La remise', 'Métras at Temps des Vendanges!', 'Gourmet meal in Toulouse', 'La remise', 'Lunch on grass at Robert Plageoles');        

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');        

        foreach($rangs as $i => $rang)
        {
            $imageevenement[$i] = new Image();
            $imageevenement[$i]->setRang($rang);                        
        }

        foreach($noms as $i => $nom)
        {            
            $imageevenement[$i]->setChemin($chemin);
            $imageevenement[$i]->setNom($nom);                        
        }

        foreach($tailles as $i => $taille)
        {
            $imageevenement[$i]->setTaille($taille);
            $imageevenement[$i]->setMimeType($mimetype);                        
        }

        foreach($legendes as $i => $legende)
        {
            $imageevenement[$i]->setLegende($legende);

            $repository->translate($imageevenement[$i], 'legende', 'en', $legendesen[$i]);             
            
            $manager->persist($imageevenement[$i]);

            $this->addReference('imageevenement-' . $i, $imageevenement[$i]);

            $imageevenement[$i]->setImageType($this->getReference('imagetype-0'));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 104; // l'ordre dans lequel les fichiers sont chargés
    }  
}