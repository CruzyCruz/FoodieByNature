<?php

// src/FBN/GuideBundle/DataFixtures/ORM/TutorialChapterParaBiodynamie.php


namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorialChapterPara as TutoChapterPara;

class TutorialChapterParaBiodynamie extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $paragraphs = array(
            'Soigner la terre et conserver la fertilité des sols , régénérer, façonner et entretenir les paysages, fournir aux êtres humains une alimentation de qualité qui nourrisse corps, âme et esprit, développer l’approche du vivant et comprendre le rôle du paysan envers la nature, les végétaux et les animaux, ouvrir de nouvelles perspectives sociales sur les fermes : lier producteurs et consommateurs (en y incluant les commerçants), lier le citoyen à la terre (partenariat ville-campagne).',
            '2010 : le Syndicat d’Agriculture Bio-Dynamique (SABD) et le Mouvement de Culture Bio-Dynamique (MCBD) fusionnent pour former un nouvel organisme : le Mouvement de l’Agriculture Bio-Dynamique (MABD). 2012 : 400 producteurs et 65 transformateurs et grossistes sont associés à la marque Demeter soit une surface d’environ 10000 ha. La biodynamie connaît à l’heure actuelle un fort développement, notamment en viticulture, y compris sur des domaines prestigieux.',
            '1990 à nos jours : L’agriculture biodynamique poursuit son extension sur tous les continents, en particulier en Asie (Inde, Chine, etc…) et en Amérique du Sud. Une initiative particulièrement innovante : Sekem a reçu le prix Nobel alternatif.L’agriculture biodynamique représente 5000 producteurs, grossistes et transformateurs certifiés Demeter sur une surface de 150 000 hectares à travers le monde. L’association Demeter International regroupe 45 pays gestionnaires de la marque .Permanence d’un délégué Demeter au Conseil de l’Europe à Bruxelles.',
            );

        $ranks = array(0, 0, 0);

        $paragraphsen = array(
            'Heal the land and maintain soil fertility, regeneration, shaping and maintaining the landscape, provide human quality food that nourishes body, soul and spirit, develop the approach of life and understand the role of the peasant to nature, plants and animals, opening new social perspectives on farms: linking producers and consumers (by including merchants), link citizens to land (urban-rural partnership).',
            '2010: Union Agriculture Bio-Dynamic (SABD) and the Movement of Culture Biodynamic (MCBD) merge to form a new organization called the Movement of Agriculture Bio-Dynamic (MABD). 2012: 400 producers and 65 processors and wholesalers are associated with Demeter an area of about 10,000 ha. Biodynamics knows at present a strong development, especially in viticulture, including prestigious areas.',
            '1990 to present: Biodynamic agriculture continues to expand on all continents, especially in Asia (India, China, etc ...) and South America. A particularly innovative initiative Sekem received the Nobel alternatif.L\'agriculture biodynamic price represents 5,000 producers, wholesalers and processors certified Demeter on 150,000 hectares worldwide. The Demeter International association includes 45 country managers .Permanence Demeter mark of a delegate to the Council of Europe in Brussels.',            );

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutorialchapter_ids = array(
            1,
            2,
            3,
            );

        foreach ($paragraphs as $i => $paragraph) {
            $tutorialchapterpara[$i] = new TutoChapterPara();
            $tutorialchapterpara[$i]->setParagraph($paragraph);
            $repository->translate($tutorialchapterpara[$i], 'paragraph', 'en', $paragraphsen[$i]);
        }

        foreach ($ranks as $i => $rank) {
            $tutorialchapterpara[$i]->setRank($rank);

            $manager->persist($tutorialchapterpara[$i]);

            $tutorialchapterpara[$i]->setTutorialChapter($this->getReference('tutorialchapterbiodynamie-'.($tutorialchapter_ids[$i] - 1)));

            $this->addReference('tutorialchapterparabiodynamie-'.$i, $tutorialchapterpara[$i]);

            $tutorialchapterpara[$i]->setImage($this->getReference('imagetutorialchapterparabiodynamie-'.$i));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 714; // l'ordre dans lequel les fichiers sont chargés
    }
}
