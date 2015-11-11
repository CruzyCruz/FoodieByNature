<?php
// src/FBN/GuideBundle/DataFixtures/ORM/Vigneron.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Vigneron as Vnr;

class Vigneron extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $names = array('Didier Barral', 'Marcel Lapierre', 'Elian Da Ros', 'Robert Plageoles', 'Jacques Selosse');

        $descriptions = array(
            'Didier Barral a parcouru un long chemin depuis son installation sur les schistes paternels de Lenthéric, au début des années 1990. En quête d’une expression authentique de son terroir, il ne ménage pas sa peine à la vigne. Aidé de son frère, Jean-Luc, ce vigneron obstiné a mis en place un mode de culture permettant de respecter l’écosystème, de favoriser les interactions entre règne végétal et animal, et de renforcer au plus loin l’immunité de la vigne. Côté cave, comme la vendange est très saine et les raisins d’excellente constitution, l’élevage est « biblique ». Après quelques risques pris il y a une dizaine d\'années, les vins sont revenus depuis 2003 à un niveau d\'exigence sans faille. Le Tradition est une entrée de gamme aux arômes personnalisés et aux tanins doux. Autour de la trilogie syrah, grenache, mourvèdre, le Jadis annonce la puissance du style Barral : un vin entier, mûr, qui parle en force mais très justement, avec une expression toujours un rien sauvage, et auquel l\'aération est bénéfique. Une utilisation minimale du soufre explique l’acidité volatile parfois haute sur les années de grande chaleur ; acidité qui, dans la cuvée Valinière, exalte les arômes cacaotés et poivrés de la syrah et du mourvèdre. Pas de vente directe à la propriété, mais les Barral communiquent volontiers les adresses de leurs cavistes fidèles. De par leur singularité, leur caractère profondément original et noblement paysan, les vins de Didier Barral font désormais partie des références essentielles du Languedoc.',
            'Marcel Lapierre, disparu en 2010, était un adepte des vins naturels et l’un des vignerons les plus emblématiques du Beaujolais. C’est sa femme et son fils Mathieu (ancien cuisinier), déjà à ses côtés depuis 2005, qui poursuivent son travail dans la même philosophie. La force du domaine, en culture biodynamique, réside aussi dans l’âge moyen du vignoble, qui frôle les soixante ans, ainsi que dans la situation des vignes, sur le fameux terroir de la côte du Py (2 ha) et sur les secteurs de Corcelette et de Montplain. Le domaine s’approvisionne également en achat de raisins. La vinification reste classique (raisin entier en semi-macération carbonique beaujolaise sans SO2). Le vin est élevé en moyenne neuf mois en pièces âgées de trois à treize ans. La qualité des derniers millésimes force le respect. ',
            'Adepte de la biodynamie, Elian Da Ros, qui a fait ses classes au domaine Zind-Humbrecht en Alsace, s’est installé dans les côtes du Marmandais en 1998. La qualité des vins et la forte personnalité de leur géniteur ont permis au domaine de se hisser rapidement au plus haut niveau de l’appellation. Sa notoriété et son exemplarité dépassent aujourd’hui largement ce cadre. Le rare cépage local Abouriou trouve ici son plus ardent défenseur et son meilleur interprète. Blancs, rouges ou même rosés, du vin de soif gourmand aux vins d’ambition travaillés et élevés sous bois, qui exigent de vieillir en cave, tous méritent d’être découverts pour leur tempérament affirmé et intègre.',
            'Il fait du vin comme il fait du vélo. Assis sur le guidon avançant en regardant en arrière, ainsi qu’il l’apprend à son petit-fils. Ce gamin pétillant de 73 ans a conservé intactes ses aptitudes d’équilibriste. «Le jour où vous vous prenez au sérieux et qu’on vous prend comme tel, vous êtes mort...» explique Robert Plageoles. Trois heures avec lui, c’est voir un grand film...
            Cet homme est un paradoxe vivant. A l\'heure où les “modernes“ à la vision mondialisée défendent les vins de cépages, avec leur zéro-défaut et leur goût formaté comme du pepsi, Robert Plageoles n’a eu de cesse de ressusciter des cépages oubliés en expérimentant le savoir des anciens. Les bases étaient là. Son vignoble de Gaillac remonte aux Romains. Et son père lui a transmis le secret de la fermentation naturelle et deux rangées plantées d’Ondenc, un cépage capable de donner des vins liquoreux de haut niveau.',
            'Aussi forts de caractère que fins en bulles, les champagnes d’Anselme Selosse peuvent être déroutants lors d’une première approche. Comme l’œuvre de tout grand créateur, ils s’apprivoisent. Puis, sans que l’on s’en rende compte, ils changent votre perception du champagne en vous rendant surtout plus exigeant ! Peu de vins au monde possèdent une telle profondeur, une telle résonance. Le travail complet du vignoble, la cueillette à maturité optimale, les vinifications sous de multiples origines de bois (en assemblage façon solera, chaque millésime ancien éduque les plus jeunes dans l’esprit des grands jerez) ou encore un stock de six ans en bouteilles qui continue de croître : tous ces procédés, tous ces efforts sont au service d’une expression toujours plus harmonieuse des terroirs. Le domaine constitué par Jacques, le père d’Anselme, compte une quarantaine de parcelles sur la côte des Blancs, en chardonnay, réparties essentiellement sur Avize mais également sur Cramant, Oger et Le Mesnil-sur-Oger – complétées depuis avec du pinot noir venu d’Aÿ, d’Ambonnay et de Mareuil. La production (570 000 bouteilles/an) se compose d\'Initial, principale cuvée (330 000 bouteilles) d\'un chardonnay multimillésimé, d\'un millésimé également blanc de Blancs et de six lieux-dits dont les premières cuvées sont sorties en 2011.',
            );

        $authors = array('CB', 'AH', 'CB', 'AH', 'AH',); 
    
        $descriptionsen = array(
            'Didier Barral has come a long way since its installation on the paternal Lentheric Shale in the early 1990s looking for an authentic expression of its terroir, it is sparing no effort in the vineyard. Assisted by his brother, Jean-Luc, this obstinate winemaker has developed a method of cultivation to respect the ecosystem, to promote interactions between plant and animal kingdoms, and strengthen further the immunity of the vine. The cellar, as the grapes are very healthy grapes of excellent constitution, breeding is "biblical". After a few risks taken there about ten years, the wines have returned since 2003 to a level of demand flawless. The Tradition is an entry-level to custom flavors and soft tannins. Around the trilogy syrah, grenache, mourvedre, the announcement Jadis power Barral style: a full, ripe, speaking in strength but very precisely with a phrase always a wild anything, and that ventilation is beneficial. Minimal use of sulfur explains the sometimes high volatile acidity on years of great heat; acidity in the wine Valinière exalts cocoa and peppery aromas of Syrah and Mourvedre. No direct sales to property, but Barral readily communicate the addresses of their loyal wine shops. Due to their uniqueness, their deeply original and noble peasant character, the wines of Didier Barral become part of the essential references of Languedoc.',
            'Marcel Lapierre, who died in 2010, was a follower of natural wines and one of the most iconic Beaujolais winemakers. His wife and his son Mathieu (former chef) already by his side since 2005, pursuing his work in the same philosophy. The strength of the field, biodynamic, also lies in the average age of the vineyard, which is approaching sixty, and in the situation of vineyards on the famous terroir Coast Py (2 ha) and areas of Corcelette and Montplain. The field also buys grapes purchase. Winemaking is classic (whole grapes into semi-carbonic maceration Beaujolais without SO2). The wine is aged on average nine months in older parts of three to thirteen. The quality of recent vintages commands respect.',
            'Follower of biodynamics, Elian Da Ros, who learned his Zind-Humbrecht the field in Alsace, settled in the coasts of Marmande in 1998 The quality of the wines and the strong personality of their parent allowed the field grow rapidly at the highest level of name. Its reputation and exemplary now far exceed this framework. The rare local grape Abouriou finds its most ardent defender and best performer. White, red or even pink, wine greedy thirst to high ambition wines and worked in wood, which require cellaring, all deserve to be discovered for their temperament and integrates said.',
            'He makes wine as he biked. Sitting on the handlebars forward by looking back, as he learns to his little son. This bubbly boy of 73 years has kept intact its balancing skills. "The day you take it seriously and that you take it as such, you\'re dead ..." said Robert Plageoles. Three hours with him, is to see a great movie ...
            This man is a living paradox. At a time when "modern" global vision to defend varietal wines, with their zero-defect and formatted as Pepsi taste, Robert Plageoles has never ceased to resurrect forgotten varieties by testing the knowledge of old. The basics were there. The vineyards of Gaillac dates back to the Romans. And his father sent him the secret of natural fermentation and planted two rows of Ondenc a grape capable of giving high-level dessert wines.',
            'Also strong character that ends in bubbles, champagne Anselme Selosse can be confusing for a first approach. As the work of any great creator, they tamed. Then, without anyone noticing, they change your perception of champagne by going especially more demanding! Few wines in the world have such depth, such a resonance. The complete work of the vineyard, picking at optimum ripeness, vinification in multiple origins of logs (assembly solera way, each old vintage educates more young people in the spirit of the great sherry) or a stock of six years in bottle that continues to grow all these processes, all these efforts are in the service of an increasingly harmonious expression of terroir. The field consists of Jacques, Father Anselm, has forty plots on the Côte des Blancs, Chardonnay spread mainly but also Cramant Avize, Oger and Le Mesnil-sur-Oger - Completed since with pinot noir came from Ay Ambonnay and Mareuil. Production (570,000 bottles / year) consists of initial, main cuvée (330,000 bottles) of a multimillésimé chardonnay, also a vintage white whites and six localities whose first wines were released in 2011 .',
            );

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach($names as $i => $name)
        {
            $vnr[$i] = new Vnr();
            $vnr[$i]->setName($name);            
        }           

        foreach($descriptions as $i => $description)
        {
            $vnr[$i]->setDescription($description);

            $repository->translate($vnr[$i], 'description', 'en', $descriptionsen[$i]); 
        }

        foreach($authors as $i => $author)
        {
            $vnr[$i]->setAuthor($author);  
        
            $manager->persist($vnr[$i]);  

            // Remarque : ici on a pas besoin de renseigner l'attribut $vigneronDdomaine de l'entite Vigneron
            // car ce n'est pas un attribut mappé. Il permet uniquement de rendre la relation bi-directionnelle.
            // L'attribut $vigneron de l'entite VigneronDomaine est renseigné par la datafixture VigneronDomaine.php
                                                
            $this->addReference('vigneron-' . $i, $vnr[$i]);

            $vnr[$i]->setImage($this->getReference('imagevigneron-' . $i));
        }                   
            
        $manager->flush();
    }

    public function getOrder()
    {
        return 402; // l'ordre dans lequel les fichiers sont chargés
    }
}