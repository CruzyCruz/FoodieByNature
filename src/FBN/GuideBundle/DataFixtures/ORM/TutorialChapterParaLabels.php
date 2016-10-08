<?php

// src/FBN/GuideBundle/DataFixtures/ORM/TutorialChapterParaLabels.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorialChapterPara as TutoChapterPara;

class TutorialChapterParaLabels extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $paragraphsfr = array(
            'Deux lettres sur un fond vert, ce label-là, forcément vous le connaissez. Propriété du Ministère de l’Agriculture, il est le plus répandu en France. Depuis 2009, le cahier des charges de la marque s’est aligné sur la réglementation européenne perdant quelques exigences au passage (la co-existence de cultures bio et non bio sur le même site par exemple). On le retrouve aussi sous la forme d’une feuille étoilée.',
            'Parce que certains agriculteurs bio n’ont pas apprécié que le logo AB perde de sa substance au moment de sa déclinaison européenne (en 2009), ils ont créé l’association Bio cohérence plus exigeante. Les fermes sont 0% OGM et 100% bio tout comme les produits transformés. Les ingrédients d’origine exotique sont autorisés à hauteur de 25% dans la composition du produit mais selon des conditions de production bien précises (commerce équitable, production biologique). La transformation, elle, doit s’effectuer en France.',
            'Ce n’est pas un label mais une mention proposée et contrôlée par des commissions maison réunissant consommateurs et professionnels (on appelle ça les Comac, commissions mixtes d’agrément et de contrôle locaux). Le tout est validé par la Fédération nationale Nature et Progrès.',
            );

        $ranks = array(0, 0, 0);

        $paragraphs = array(
            'Two letters on a green background, this label then inevitably you know it. Property of the Ministry of Agriculture, it is most prevalent in France. Since 2009, the specifications brand expenses is aligned with the European regulations losing some requirements to the passage (the co-existence of organic and non-organic crops on the same site, for example). It is also found in the form of a starry sheet.',
            'Because some organic farmers did not appreciate that the AB logo loses its substance at the time of European declination (in 2009), they created the most demanding consistency Bio association. Farms are 0% and 100% organic GMO as processed products. The exotic ingredients are allowed up to 25% in the product composition, but according to specific production conditions (fair trade, organic production). Processing, it must be done in France.',
            'It is not a label but a mention proposed and controlled house committees comprising consumers and professionals (it\'s called the Comac, mixed accreditation commissions and local control). The whole is validated by the National Federation Nature and Progress.',
            );

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutorialchapter_ids = array(
            1,
            2,
            3,
            );

        foreach ($paragraphs as $i => $paragraph) {
            $tutorialchapterpara[$i] = new TutoChapterPara();
            $tutorialchapterpara[$i]->setParagraph($paragraph);
            $repository->translate($tutorialchapterpara[$i], 'paragraph', 'fr', $paragraphsfr[$i]);
        }

        foreach ($ranks as $i => $rank) {
            $tutorialchapterpara[$i]->setRank($rank);

            $manager->persist($tutorialchapterpara[$i]);

            $tutorialchapterpara[$i]->setTutorialChapter($this->getReference('tutorialchapterlabels-'.($tutorialchapter_ids[$i] - 1)));

            $this->addReference('tutorialchapterparalabels-'.$i, $tutorialchapterpara[$i]);

            $tutorialchapterpara[$i]->setImage($this->getReference('imagetutorialchapterparalabels-'.$i));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 724; // l'ordre dans lequel les fichiers sont chargés
    }
}
