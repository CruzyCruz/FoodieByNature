<?php
// src/FBN/GuideBundle/DataFixtures/ORM/TutorielChapitreParaBoireNature.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\TutorielChapitrePara as TutoChapitrePara;

class TutorielChapitreParaBoireNature extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $paragraphes = array(
            'Avec l’élaboration de tels vins, « nature » ou « naturels », le goût du raisin et la typicité du terroir retrouvent toute leur importance. Alors que la vinification classique qui utilise le soufre comme antioxydant fixe les arômes dominants, la vinification des vins « nature » produit des vins plus complexes, dans lesquels on perçoit des parfums et des goûts plus nombreux et plus subtils. Non stabilisés, les vins naturels sont des vins vivants dont le goût et l’expression évoluent pendant la dégustation. A ce titre, ils peuvent parfois « déstabiliser » les amateurs de vins classiques : ils demandent que l’on oublie un peu ce que l’on sait, que l’on s’ouvre à de nouvelles sensations. Ce n’est pas le moindre de leur charme que d’offrir en effet des expériences de dégustations nouvelles, dans un univers où les produits sont de plus en plus standardisés et finissent tous par se ressembler.',
            'Le léger perlant, qu’on leur reproche parfois et qui excite les papilles à l’ouverture de la bouteille, peut plaire ou non : il disparaît avec un carafage, qui permet au vin de dégazer.',
            'Le nez, parfois rustique au premier abord, s’affine rapidement, avec des arômes qui évoluent beaucoup au cours de la dégustation.',
            'Moins crispés que les vins sulfités, ce sont des vins fluides, équilibrés, détendus. Leur perception en bouche est particulièrement sensuelle, charnue. Certains dégustateurs parlent de leur particulière « buvabilité » : ce sont des vins gourmands, d’une grande pureté de goût au palais, auxquels on a envie de revenir.',
            'Les vinifications « classique» et « nature » reposent finalement sur deux philosophies complémentaires qui ne sont pas contradictoires. La première vise à capter et à conserver un moment privilégié dans l’équilibre d’un vin; elle pourrait faire songer à l’approche du photographe qui saisit un instantané. La vinification « nature » veut plutôt permettre au vin de développer sa vitalité et son énergie à travers le temps ; elle pourrait évoquer la pratique du musicien, qui, entre prise de risque calculée et confiance, se lance dans une improvisation sur un thème donné.');        

        $rangs = array(0, 0, 1, 2, 0);

        $paragraphesen = array(
            'With the development of such wines, "nature" or "natural", the taste of the grape and characteristics of the terroir regain their importance. While classical winemaking using sulfur as antioxidant sets the dominant aromas, wine making wine "nature" produces complex wines, in which we perceive scents and more numerous and subtle tastes. Unstabilized, natural wines are living wines whose taste and expression change during the tasting. As such, they can sometimes "destabilize" the lovers of classic wines: they ask that we forget a little what we know, that we are open to new sensations. This is not the least of their charm as offer indeed new tasting experiences in a world where products are increasingly standardized and all end up looking the same.',
            'The slight beading, sometimes blame them and excites the taste buds at the opening of the bottle, can please or not: it disappears with a carafe, which allows the wine to degas.',
            'Nose, sometimes rustic at first, matures quickly, with flavors that change a lot during the tasting.',
            'Less tense than sulphite wines, wines that are fluid, balanced, relaxed. Their perception is particularly sensual mouth, fleshy. Some tasters talk about their "drinkability" special: they are greedy wines of great purity of taste on the palate, which we want to return.',
            'Vinification "classic" and "nature" ultimately based on two complementary philosophies that are not contradictory. The first aims to capture and retain a privileged moment in the balance of the wine; it could consider the approach of the photographer who captures a snapshot. "Nature" vinification wants rather allow the wine to develop its vitality and energy over time; it could evoke practice musician, who between calculated risk taking and trust, launches into an improvisation on a theme.');


        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $tutorielchapitre_ids = array(
            1,
            2,
            2,
            2,
            3
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

            $tutorielchapitrepara[$i]->setTutorielChapitre($this->getReference('tutorielchapitreboirenature-' . ($tutorielchapitre_ids[$i]-1))); 

            $this->addReference('tutorielchapitreparaboirenature-' . $i, $tutorielchapitrepara[$i]); 

            $tutorielchapitrepara[$i]->setImage($this->getReference('imagetutorielchapitreparaboirenature-' . $i));                                          
        }              
            
        $manager->flush();
    }

    public function getOrder()
    {
        return 744; // l'ordre dans lequel les fichiers sont chargés
    }
}