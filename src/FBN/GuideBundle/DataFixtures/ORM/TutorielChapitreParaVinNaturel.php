<?php
// src/FBN/GuideBundle/DataFixtures/ORM/TutorielChapitreParaVinNaturel.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorielChapitrePara as TutoChapitrePara;

class TutorielChapitreParaVinNaturel extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $paragraphes = array(
            'Le terroir c\'est des ceps de vignes choisis et intégrés dans un écosystème, un sol labouré, la nature du sous-sol dans lequel les racines de la plante se nourrissent, la microflore du sol, nourriture de la plante. C\'est également un vigneron et des techniques de travail plus ou moins interventionnistes.',
            'Un vin naturel est élaboré à partir de raisins mûrs issus de l’agriculture biologique ou biodynamique ayant subi le minimum de manipulations et exempts de tous produits chimiques ou de synthèse, à partir de raisins vendangés manuellement,avec des levures et bactéries naturelles ou indigènes, sans utiliser d’intrants œnologiques chimiques visant à accélérer la stabilisation ou modifier les jus, avec des techniques douces et respectueuses de l’environnement et sans l’usage du soufre ou avec des dosages homéopathiques (jusqu’à 5 fois moins de soufre pour les vins rouges et 10 fois moins pour les vins blancs que les dosages autorisés par les commissions européennes).',
            'Les vins bio proviennent de vignes cultivées selon un cahier des charges précis sans désherbage chimique et sans utilisation de produits de traitement de synthèse sont issus d’une production agricole basée sur le respect du vivant et des cycles naturels, sont contrôlés et certifiés par des organismes privés gestionnaires de marque et liés au label AB, seront 100% bio à partir de la récolte 2012 (auparavant la vinification n’était pas réglementée) et distingués par un logo de l’Union Européenne.',
            'La viticulture biodynamique se base sur des pratiques agricoles durables et l’utilisation d’outils légers qui respectent la vie du sol, a pour but de renforcer la plante en améliorant les échanges entre les micro-organismes du sol et le système racinaire de la vigne, a pour objectif de dynamiser les effets bénéfiques de la lumière solaire sur le système foliaire de la plante,  recherche une optimisation de l’expression du terroir, tient compte des cycles lunaires ayant une influence sur la croissance et la vie des plantes et utilise des composts organiques et autres préparations à base de plantes destinés à nourrir les êtres vivants du sol.');        

        $rangs = array(0, 0, 0, 0);

        $paragraphesen = array(
            'The soil\'s selected vines and integrated into an ecosystem, a plowed ground, the nature of the subsoil in which the roots of the plant feed, soil microflora, plant food. It\'s also a winemaker and more or less interventionist techniques work.',
            'A natural wine is made from ripe grapes from organic or biodynamic agriculture has undergone the minimum fuss and free of any chemicals or synthetic, from grapes harvested by hand with natural yeasts and bacteria or indigenous, without the use of chemical inputs oenological to accelerate the stabilization or modify the juice with gentle techniques that respect the environment and without the use of sulfur or with homeopathic dosages (up to 5 times less sulfur for red wine and 10 times less for white wines that dosages allowed by European commissions).',
            'Organic wines come from vines grown on a precise specification without chemical weed control and without the use of synthetic processing products come from agricultural production based on respect for nature and natural cycles are controlled and certified by organizations private brand managers and related AB label, will 100% organic from the 2012 harvest (before vinification was not regulated) and distinguished by an EU logo.',
            'Biodynamic viticulture is based on sustainable farming practices and the use of lightweight tools that respect the soil life, aims to strengthen the plant by improving exchanges between micro-organisms in the soil and the root system of the vine , aims to boost the beneficial effects of sunlight on the leaf system of the plant, search optimization of the terroir, reflects the lunar cycles affecting the growth and life of plants and uses organic composts and other plant-based foods for living beings to feed the soil.');


        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutorielchapitre_ids = array(
            1,
            2,
            3,
            4
            );            

        foreach($paragraphes as $i => $paragraphe)
        {
            $tutorielchapitrepara[$i] = new TutoChapitrePara();
            $tutorielchapitrepara[$i]->setParagraphe($paragraphe); 
            $repository->translate($tutorielchapitrepara[$i], 'paragraphe', 'en', $paragraphesen[$i]);           
        }     

        foreach($rangs as $i => $rang)
        {
            $tutorielchapitrepara[$i]->setRang($rang);  

            $manager->persist($tutorielchapitrepara[$i]);  

            $tutorielchapitrepara[$i]->setTutorielChapitre($this->getReference('tutorielchapitrevinnaturel-' . ($tutorielchapitre_ids[$i]-1))); 

            $this->addReference('tutorielchapitreparavinnaturel-' . $i, $tutorielchapitrepara[$i]); 

            $tutorielchapitrepara[$i]->setImage($this->getReference('imagetutorielchapitreparavinnaturel-' . $i));                                          
        }              
            
        $manager->flush();
    }

    public function getOrder()
    {
        return 704; // l'ordre dans lequel les fichiers sont chargés
    }
}