<?php
// src/FBN/GuideBundle/DataFixtures/ORM/Restaurant.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Info as Inf;

class Info extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $names = array('La force est avec lui !', 'Un coffee shop en cachait un autre', 'Papier à mâcher', 'Bon grain !', 'Dis camion !', 'Encore un !', 'Rien ne l\'arrête !', 'Jurassique Arnal','Papier à mâcher', 'Top 50 !');

        $descriptions = array(
            'Après la Crèmerie la semaine dernière, David Lanher (Racines, Vivant, Stern, Noglu…) vient de s’offrir le Bon Saint Pourcain, rue Servandoni dans le 6e…',
            'Le Poutch remplacera le Tuck Shop de la rue Lucien Sampaix à partir de début novembre.',
            'La BD “les Secrets du chocolat” (Delcourt), de Franckie Alarçon, nous entraînera dès le 13 novembre dans l’atelier de Jacques Genin ! 15,95 €.',
            'Luc Reversade ouvrira cet hiver à Saint-Gervais-les-Bains (74) sa cinquième Folie Douce.',
            'Le Truck d’or du Street Food International Festival vient d’être attribué à Gaston le Camion, un beau Peugeot J9 de 1979, à retrouver du lundi au vendredi sur le parvis de la gare d’Avignon.',
            'A peine un troisième Blend ouvert rue Yves Toudic que l’enseigne projette déjà d’en ouvrir un nouveau à Menilmontant…',
            'Kristin Frederick, la créatrice du Camion qui fume, lance un nouveau concept au 67, rue du Faubourg Poissonnière (Paris 9e) : Huabu, une cantine chinoise ! Ouverture prévue début 2015.',
            'Menu découverte autour des mets d’Armand Arnal et des vins jurassiens du Domaine de la Tournelle le dimanche 3 novembre, à partir de 11h, à la Chassagnette. 100 € par personne.',
            'Pour apprendre à faire des crêpes aussi bonnes que celles du Breizh Café, on se rue sur le livre de recettes éponyme qui sort le 23 octobre aux Editions de La Martinière ! 25 €.',
            'Classé 17ème, Candelaria est le premier bar français à entrer dans les 50 meilleurs bars du monde. Classement établi par 334 professionnels du secteur, répartis dans 46 pays, et dévoilé dans Drinks International.',
            );

        $namesen = array('The force is with him!', 'A coffee shop in another hiding', 'Paper chewing', 'Good grain !', 'Dis camion !', 'Another one!', 'Nothing\'s stop!', 'Jurassic Arnal','Paper chewing', 'Top 50 !');

        $descriptionsen = array(
            'After Creamery last week, David Lanher ( Roots , living, Stern, Noglu ... ) just to afford the Bon Saint Pourcain Servandoni street in the 6th ...',
            'The Tuck Shop Poutch replace street Lucien Sampaix from early November.',
            'BD " Secrets of Chocolate " ( Delcourt ) of Frankie Alarcon , lead us from November 13 in the studio of Jacques Genin ! € 15.95.',
            'Luc Reversade open this winter in Saint-Gervais-les-Bains (74) fifth Folie Douce.',
            'The gold of the Street Food Truck Festival has been assigned to Gaston Truck , a beautiful Peugeot J9 1979 to recover from Monday to Friday on the steps of the Avignon train station.',
            'Barely a third open Blend rue Yves Toudic the sign already planning to open a new Menilmontant...',
            'Kristin Frederick , creative Truck smokes , is launching a new concept at 67 rue du Faubourg Poissoniere ( Paris 9th ) : Huabu , a Chinese canteen! Opening in early 2015.',
            'Menu découverte autour des mets d’Armand Arnal et des vins jurassiens du Domaine de la Tournelle le dimanche 3 novembre, à partir de 11h, à la Chassagnette. 100 € par personne.',
            'Tasting menu around dishes Armand Arnal and Jura wines from Domaine de la Tournelle Sunday, November 3 , from 11am to Chassagnette . € 100 per person.',
            'Ranked 17th , Candelaria is the first French bar to enter the top 50 bars in the world. Ranking by 334 professionals, in 46 countries, unveiled in Drinks International.',
            );

        $auteurs = array('CB', 'AH', 'CB', 'AH', 'AH', 'CB', 'AH', 'CB', 'AH', 'AH');         
        

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach($names as $i => $name)
        {
            $news[$i] = new Inf();
            $news[$i]->setName($name);   

            $repository->translate($news[$i], 'name', 'en', $namesen[$i]);          
        }   

        foreach($descriptions as $i => $description)
        {
            $news[$i]->setDescription($description);

            $repository->translate($news[$i], 'description', 'en', $descriptionsen[$i]); 
        }

        foreach($auteurs as $i => $auteur)
        {
            $news[$i]->setAuteur($auteur);  

            $manager->persist($news[$i]);  
            
            //$restaurant[$i]->setImage($this->getReference('imagerestaurant-' . $i));     
                         
        }    
                           
        $manager->flush();
    }

    public function getOrder()
    {
        return 601; // l'ordre dans lequel les fichiers sont chargés
    }
}