<?php

// src/FBN/GuideBundle/DataFixtures/ORM/TutorialChapterParaMacerationCarbonique.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorialChapterPara as TutoChapterPara;

class TutorialChapterParaMacerationCarbonique extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $paragraphsfr = array(
            'Elle nécessite des baies de raisins intactes : On doit donc impérativement faire les vendanges à la main en récipients bas. La technique consiste à mettre les grappes entières, non éraflées et non foulées, dans une cuve hermétique saturée de dioxyde de carbone. Il se produit alors une fermentation intracellulaire que Louis Pasteur, après Lechartier et Bellamy, avait déjà décrite.',
            'Un ou deux jours avant le début des vendanges, le vigneron récolte l\'équivalent de 10 % du volume d\'une cuve. Il foule ce raisin pour bookmarkser un départ en fermentation rapide et un début de production de CO2. Ce pied de cuve va permettre de saturer la cuve en CO2 et d\'isoler la vendange de l\'action de l\'oxygène. L\'écrasement progressif de la vendange sous son poids et du fait de la fermentation alcoolique va libérer progressivement du moût dans la cuve. Après cette phase de macération carbonique la vinification peut se poursuivre selon un schéma classique. Cependant le décuvage se fait avant complète fermentation; cette méthode permet une extraction plus rapide des anthocyanes colorantes et des précurseurs d\'arômes. De plus, la maîtrise de la fin de fermentation est plus facile en moût que sous marc. Le gaz carbonique produit par la première cuve servira à inerter les cuves suivantes.',
            'Utilisée depuis longtemps en Beaujolais, cette technique a été mise en avant pour la production de vins nouveaux ou primeurs. Il ne faut cependant pas la réduire à ce segment de marché, puisque dans le même vignoble, elle sert à élaborer des vins de garde dans les crus comme Morgon ou Moulin à vent.',
            );

        $ranks = array(0, 0, 0);

        $paragraphs = array(
            'It requires intact grape berries: So we must always do the harvest by hand down containers. The technique is to put the whole bunches, not scratched and not steps, in a sealed tank saturated with carbon dioxide. This produces an intracellular fermentation Louis Pasteur after Lechartier and Bellamy had already described.',
            'One or two days before the start of the harvest, the winemaker harvest the equivalent of 10% of the volume of a tank. He treads the grapes to foster a quick fermentation onset and CO2 production start. This base stock will allow saturating CO2 tank and isolate the vintage of the action of oxygen. The progressive crushing of the grapes under his weight and because of the alcoholic fermentation of the must gradually release the vessel. After this phase carbonic maceration winemaking can proceed in a conventional scheme. However, the racking is done before complete fermentation; This method allows faster extraction of anthocyanins coloring and flavor precursors. In addition, control of the end of fermentation is easier than in wort grounds. The carbon dioxide produced by the first vessel will be used to inert the following tanks.',
            'Long used in Beaujolais, this technique has been put forward for the production of new or young wines. It does, however, be reduced to this market segment, as in the same vineyard, it is used to develop wines for in raw as Morgon or Windmill.',            );

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

            $tutorialchapterpara[$i]->setTutorialChapter($this->getReference('tutorialchaptermacerationcarbonique-'.($tutorialchapter_ids[$i] - 1)));

            $this->addReference('tutorialchapterparamacerationcarbonique-'.$i, $tutorialchapterpara[$i]);

            $tutorialchapterpara[$i]->setImage($this->getReference('imagetutorialchapterparamacerationcarbonique-'.$i));
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 734; // l'ordre dans lequel les fichiers sont chargés
    }
}
