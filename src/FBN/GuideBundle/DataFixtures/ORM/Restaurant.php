<?php
// src/FBN/GuideBundle/DataFixtures/ORM/Restaurant.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Restaurant as Resto;

class Restaurant extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
    
        $noms = array('Le Temps des Vendanges', 'Naturellement', 'La Fine Mousse', 'Dix-Huit', 'Cantine California');

        $descriptions = array(
            'Une apparition qui va combler les Bellevillois : un café moderne, toujours ouvert, avec terrasse sol y sombra, canapés et baby-foot. Valentin Bauer et Grégory Cossu ont dépouillé l’ancien café La Triplette, et rhabillé ce grand volume de parquet, de marbre et de miroirs. Ce qui dessine une belle tranche de boulevard pour petit-déjeuner avec œufs au bacon, bruncher le week-end, cocktailiser à la coule (pour seulement 5 € de 17 à 21 heures !) ou manger tout simplement… Ex-chef de Quedubon, Sofiane Saadi Haddad n’envoie que des petits plats bien foutus : bouillon du jour, harengs marinés, terrine de tête, poisson cru, burger à l’épaule de veau, mozza et pickles, riz au lait nappé de caramel au rhum, crumble pomme-framboise… Le tout servi sans temps morts par une équipe ardente comme un commando de marine. Mention spéciale pour le fish & chips : un beau morceau de cabillaud cuit en tempura et des frites avec la peau. Petite carte de vins estimables, au verre (3 à 5 €), en pichet et en bouteille : viognier Domaine des Salices, bourgueil Trinch des Breton, crozes-hermitage de Guigal, côtes-du-roussillon Le Petit Dernier… Formules 6-9 € (petit déjeuner), 12-16 € (midi, café offert), brunch 16 €, carte 19-28 €.',
            'Un tuyau qui venait d’on ne sait plus où, mais qui disait : « Rue Mademoiselle, un petit Italien qui ne paie pas de mine mais qui sert des vins géniaux. » On confirme : face à un immeuble aussi pimpant que le QG de la Stasi à Karl-Marx-Stadt, niche un bistrot à l’ancienne avec carrelage vieux Paris et mobilier en bois lustré. Dedans ? Giovanni, un Napolitain, aux prises avec une mortadelle de Bologne, starter nickel pour tapisser la descente et faire glisser ce qui suit : superbe carpaccio de maigre, huile-d’olivé, flanqué de rondelles de courgettes et d’aubergines vapeur, avec un vernaccia di San Giminiano blanc Montenidoli 2010 ; délicieux encornets aux petits pois, servis dans une belle assiette à fleurs, arrosés de rosso di verzella (Etna) 2007 ; et chouette madeleine façon tiramisu en dessert. La cuisine est faite à l’humeur, dans un réduit, selon le marché (top) : saint-jacques pistache-orange, salade d’artichauts poivrade, côtes d’agneau panées, charcuteries et fromages… Mais qui est ce Giovanni ? Renseignements pris au bar, en compagnie d’un limoncello maison : un ancien de Rap, épicerie italienne de la rue Rodier, et de La Cantina, la cave à manger la plus dingue de Venise ! Carte 26-36 €. Vins au verre 5-7 €, droit de bouchon 5 €.',
            'La culture bière, en France, oscille le plus souvent entre folklore alsacien et beuveries irish, choucroute/Fisher et pizza/Bavaria… Il était temps de revoir tout ça et d’élargir l’horizon. La Fine Mousse, éminent bar à bières artisanales du côté d’Oberkampf, vient donc de signer le premier restaurant « biéronomique » de Paris, censé éveiller les masses aux subtilités d’un repas tout-mousse. Sommeliers hyper motivés et chef concerné (William Ransone, ex-Bistrot Urbain) sortent les grands crus pour une dégustation mets-bières en six étapes. Exemples : jabugo pata negra et gueuze bruxelloise naturellement acide Cantillon ; saint-jacques, asperge blanche crues, concombre mariné et kumqat, avec une campagnarde italienne blonde et fraîche Duchessa ; poitrine de porc Kintoa, semoule au cacao, avec une brune allemande acidulée Methusalem Sour Altbier ; carotte blanche confite, caramel à l’orange sanguine, sablé au thé vert, et barley wine italienne Dudes, sombre et lourde… Avant la petite dernière : une exceptionnelle hollandaise Bommen & Granaten Bordeaux, complexe, confite, et dont les 15,2° passent tout seuls… Facture 79 € avec accords mets-bières (54 € sans, mais quel intérêt ?), et plats de 5 à 25 € en libre choix dans l’autre salle.',
            'Est-il bien raisonnable d’ouvrir un bistrot contemporain dans un quartier radicalement bourgeois ? Julien Peret a décidé d’en faire l’expérience en campant son Dix-Huit (nom un peu bof choisi lors d’un brain-storming infructueux ?) dans le très cossu quartier des Ternes. Certes, la déco (parquet peint, orchidées, bois arborescents…) s’essaie un peu maladroitement à ménager la chèvre permanentée et ses petits choux mal peignés, mais la formule devrait vite mettre tout le monde d’accord. Car le chef Aaron Isip, lui, ne se pose pas de questions. Passé par les cases Apicius, Drouant, Ze Kitchen Galerie et Pan, ce cuistot d’origine philippine envoie des assiettes au discours tranché : ceviche de dorade uniformément rose, radis en pickles, oignons rouges et neige de pamplemousse ; turbot parfait, tout en rondeur, sauce moussée de coques et palourdes au lait de coco, pak choi, pourpier et écrasé de vitelotte ; puis odorant gaspacho de fraises, feuilles de peppermint et litchi. Le tout pour 24 € dans une formule déjeuner extraite de la carte (39-44 €). Cave bien sentie (marsanne de Cuilleron et côtes-du-rhône Domaine de La Janasse à 5 € le verre, chapelle-chambertin de Trapet 2003 à 124 € la bouteille), et profond café du Pérou pour finir ailleurs… Tiens, un peu plus, on y emménagerait !',
            'L’Américano-Canadien Jordan Feilders vient de garer sa Cantine California à deux roues de la station Arts et Métiers. Dans un bel endroit tout en bois brut et marbre, avec comptoir à gauche et table d’hôte à droite, qui sent plus le neuf que la friture (bonne aération). La carte est peu ou prou identique à celle du food truck qui continue à régaler quatre fois par semaine aux marchés Raspail et Saint-Honoré. Sur assiette cette fois, et parmi d’autres : Cali Classic burger (au bœuf bio français haché sur place, orgasmique tellement il dégouline de real cheddar et d’avocat écrasé) avec frites croustillantes à tout va, tacos pas secs (épaule de porc bio mijotée sept heures au piment chipotle, pico de gallo, piment, coriandre et citron vert), salades (au hasard : kale, fromage de chèvre, pomme, noix, canneberge et fenouil), mais encore, granola maison, pancakes, carrot cake, brownie, banana nut muffin… Suivant l’heure et le jour, on se rince la bouche au jus de pamplemousse pressé (6 €), à la bière locale (Gallia et Deck & Donohue) ou à la margarita (6 € le verre, 25 € le pichet d’un litre). Burgers avec frites 15 €, tacos 7-19 €, desserts 2-3 €.',
            );

        $auteurs = array('CB', 'AH', 'CB', 'AH', 'AH',); 

        $restaurateurs = array('Eric Cuestas', 'Jérôme Navarre', 'Jean-François Piège', 'Christian Constant', 'Thierry Marx',);

        $hrefs = array('http://www.letempsdesvendanges.com', null, 'http://www.lafinemousse.fr', 'http://www.dix-huit.fr', 'http://www.cantinecalifornia.com');

        $tels = array('05 61 42 94 66', '01 45 89 75 62', '01 12 47 85 96', '01 47 85 96 54', '01 47 52 14 89');            

        $sites = array('letempsdesvendanges.com', null, 'lafinemousse.fr', 'dix-huit.fr', 'cantinecalifornia.com');

        $horaires = array(
                        'Tous les jours, de 8h à 1h30 ; service de midi à 15h30 et de 19h à 23h30.',
                        'De midi à 14h30 et de 19h à 23h. Fermé dimanche.',
                        'De 19h à 22h30. Fermé dimanche et lundi.',
                        'De midi à 14h30 (sauf samedi) et de 19h30 à 23h. Fermé dimanche. ',
                        'Tous les jours, de 11h30 à 15h et de 19h30 à 22h30 (22h le dimanche).', 
                        );

        $descriptionsen = array(
            'An apparition that will have the inhabitants of Belleville buckling at the knees: a modern café, always open, with a sol y sombra terrace, couches and foosball. Valentin Bauer and Grégory Cossu have stripped the former La Triplette café and redid this big, voluminous space with hardwood floors, marble and mirrors. Which draws a hefty slice of the boulevard for breakfast with bacon and eggs, brunch on the weekends, chill cocktail hours (only €5 from 5 to 9pm!) or just to eat… The ex-chef of Quedubon, Sofiane Saadi Haddad is only sending out damn well-assembled dishes: bouillon of the day, marinated herring, terrine de tête, raw fish, veal shoulder burger, mozza and pickles, rice pudding topped with rum caramel, apple-raspberry crumble…All served without any dead time by a team that’s as ardent as an admiral. Special mention for the fish & chips: a beautiful cut of cod cooked in tempura and served with fried potatoes, skin on. Respectable little wine list, by the glass (€3 to €5), by the pitcher or the bottle: Viognier Domaine des Salices, Bourgueil Trinch des Breton, Crozes-Hermitage de Guigal, Côtes-du-Roussillon Le Petit Dernier…Formulas €6-9 (breakfast), €12-16 (lunch, coffee included), brunch €16, carte €19-28',
            'A tip that came from who knows where, but which said: “Rue Mademoiselle, a little Italian place that doesn’t look like much but that serves great wines.” We’re here to confirm it: facing a building that’s about as dapper as the Stasi HQ at Karl-Mark-Stadt, hides an old-fashioned bistro with vintage Parisian tiling and lustered wooden furniture. Inside? Giovanni, a Neapolitan, at the controls with a mortadelle de Bologne, a perfect starter to wake up your appetite and help what follows slide down smoothly: superb meagre carpaccio, olive oiled, surrounded by rounds of steamed zucchini and eggplant, with a Vernaccia di San Giminiano, white Montenidoli 2010; delicious squid with peas, served on a beautiful floral plate, washed down with rosso di Verzella (Etna) 2007; and a nice tiramisu-style madeleine for dessert. The cuisine is made according to the chef’s mood, in a cubbyhole of a kitchen, according to the market (the best products): scallops with pistachio and orange, artichoke poivrade salad, breaded lamb chops, charcuteries and cheeses…. But who is this Giovanni? We got the scoop at the bar, accompanied by a homemade limoncello: formerly of Rap, an Italian épicerie on rue Rodier, and also of La Cantina, Venice’s most insane cave à manger! Carte €26-36. Wines by the glass €5-7, corkage €5.',
            'Beer culture, in France, often oscillates between Alsatian folklore and Irish brews, choucroute/Fisher and pizza/Bavaria…It was high time to rethink all that and to expand our horizons. La Fine Mousse, an eminent artisanal beer bar near Oberkampf, just opened the first “biéronomique” restaurant in Paris, with the intention of awakening the masses to the subtleties of a very moussey meal. Hyper motivated sommeliers and an involved chef (William Ransone, ex-Bistrot Urbain) are taking out the grands crus for a food-beer tasting menu in 6 courses. Examples: jabugo pata negra and Cantillon, a gueuze bruxelloise that’s naturally acidic; scallops, raw white asparagus, marinated cucumber and kumquat, with a country-style Italian brew, the blond and fresh Duchessa; Kintoa pork breast, semolina with cacao, with an acidic German brown ale, the Methusalem Sour Altbier; slow-cooked white carrot, blood orange caramel, green tea sablé, and Italian barley wine, the Dudes, somber and heavy…Before the last one: an exceptional Dutch Bommen & Granaten Bordeaux, complex, whose 15.2° go down very easily… Bill €79 with beer-food pairings (€54 without it, but what’s the point?) and dishes from €5 to €25 for the pickings in the other room.',
            'Is it really wise to open a contemporary bistro in a radically bourgeois part of town? Julien Peret decided to test his luck by camping out his Dix-Huit (a rather average name chosen during a fruitless brainstorming session?) in the very affluent Ternes neighborhood. Certainly, the décor (painted hardwood floors, orchids, arborescent woodwork…) is a little awkward, but the formula should quickly have everyone seeing eye to eye. Because the chef Aaron Isip doesn’t ask any questions. Passed through the ranks of Apicius, Drouant, Ze Kitchen Galerie and Pan, this cook of Filipino origin sends out plates that will give you pause mid-sentence: uniformly pink sea bream ceviche, pickled radishes, red onions and a sprinkling of grapefruit; perfect turbot, well-rounded, moussey sauce of coque and palourde clams with coconut milk, bok choy, purslane and smashed vitelotte potatoes; then a fragrant strawberry gazpacho with peppermint leaves and litchi. Everything for €24 in a lunch formula extracted from the menu (€33-44). A well thought-out cellar (Marsanne de Cuilleron and Côtes-du-Rhône Domaine de La Janasse at €5 a glass, Chapelle-Chambertin de Trapet 2003 at €124 the bottle) and rich coffee from Peru to finish the meal elsewhere… Hey, a little more, and we’d change neighborhoods!',
            'The Americano-Canadian Jordan Feilders just parked his Cantine California roughly two turns of a wheel from the Arts et Métiers metro station. In a beautiful space that’s all raw wood and marble, with the counter to the left and the communal table to the right, it smells more like newness than fried foods (good ventilation). The menu is more or less identical to that of the food truck that continues to delight folks four times a week at the Raspail and Saint-Honoré markets. On a plate this time, and amongst other treats: the Cali Classic burger (with organic French beef that’s ground on-site, orgasmic when its dripping with real cheddar and smashed avocado) with crispy fries, tender tacos (organic pork shoulder stewed for seven hours with chipotle pepper, pico de gallo, chilies, cilantro and lime), salads (a random pick: kale, goat cheese, walnut, cranberries and fennel), and the list goes on…homemade granola, pancakes, carrot cake, brownies, banana nut muffins… According to the hour and the day, we rinse it all down with freshly squeezed grapefruit juice (€6), local beer (Gallia and Deck & Donohue) or with a margarita (€6 a glass, €26 for a 1 liter pitcher). Burger with fries €15, tacos €7-19, desserts €2-3.',
            );

        $horairesen = array(
                        'Everyday, from 8am to 1:30am; meal service from noon to 3:30pm and from 7pm to 11:30pm.',
                        'From noon to 2:30pm and from 7pm to 11pm. Closed Sunday.',
                        'From 7pm to 10:30pm. Closed Sunday and Monday.',
                        'From noon to 2:30pm (except Saturday) and from 7:30pm to 11pm. Closed Sunday.',
                        'Everyday, from 11:30am to 3pm and from 7:30pm to 10:30pm (10pm Sunday).', 
                        );


        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach($noms as $i => $nom)
        {
            $restaurant[$i] = new Resto();
            $restaurant[$i]->setNom($nom);            
        }   

        foreach($descriptions as $i => $description)
        {
            $restaurant[$i]->setDescription($description);

            $repository->translate($restaurant[$i], 'description', 'en', $descriptionsen[$i]); 
        }

        foreach($auteurs as $i => $auteur)
        {
            $restaurant[$i]->setAuteur($auteur);  
                    
        }    

        foreach($restaurateurs as $i => $restaurateur)
        {
            $restaurant[$i]->setRestaurateur($restaurateur);          
                          
        }  

        foreach($hrefs as $i => $href)
        {
            $restaurant[$i]->setHref($href);          
                          
        } 

        foreach($tels as $i => $tel)
        {
            $restaurant[$i]->setTel($tel); 
        }            

        foreach($sites as $i => $site)
        {
            $restaurant[$i]->setSite($site);          
                          
        }          

        foreach($horaires as $i => $horaire)
        {
            $restaurant[$i]->setHoraires($horaire);

            $repository->translate($restaurant[$i], 'horaires', 'en', $horairesen[$i]); 

            $manager->persist($restaurant[$i]);  
            
            $restaurant[$i]->setRestaurantPrix($this->getReference('restaurantprix-'   . rand(0 ,3)));
            $restaurant[$i]->addRestaurantStyle($this->getReference('restaurantstyle-' . rand(0,1)));            
            $restaurant[$i]->addRestaurantStyle($this->getReference('restaurantstyle-' . rand(2,3)));
            $restaurant[$i]->addRestaurantBonus($this->getReference('restaurantbonus-' . rand(0,1)));
            $restaurant[$i]->addRestaurantBonus($this->getReference('restaurantbonus-' . rand(2,3)));

            $restaurant[$i]->setCoordonnees($this->getReference('coordonnees-' . $i));

            $restaurant[$i]->setImage($this->getReference('imagerestaurant-' . $i));

            $this->addReference('restaurant-' . $i, $restaurant[$i]);

        }        
            
        $restaurant[0]->setCaviste($this->getReference('caviste-0'));

        $manager->flush();
    }

    public function getOrder()
    {
        return 304; // l'ordre dans lequel les fichiers sont chargés
    }
}