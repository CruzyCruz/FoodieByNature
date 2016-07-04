<?php

// src/FBN/GuideBundle/DataFixtures/ORM/Event.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Event as Evt;

class Event extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $names = array('Yvon Métras au Temps des Vendanges', 'Repas Gastronomique à Toulouse', 'Sous les pavés, la vigne !', 'La remise', 'Yvon Métras au Temps des Vendanges', 'Repas Gastronomique à Toulouse', 'La remise', 'Déjeuner sur l\'herbe chez Robert Plageoles');

        $descriptions = array(
            'Au Temps des Vendanges ce Samedi 13 Septembre, dégustation des nouvelles cuvées de Fleurie et Beaujolais du Domaine Yvon Métras avec pour cette année, le retour du Fleurie "Le Printemps".',
            'Lors d\'un repas exceptionnel réalisé à l\'Amphitryon (Restaurant 2 étoiles Michelin à Colomiers), Yannick Delpech, Aziz Mokhtari (Les Petits Fayots) et Nicolas Brousse (Monsieur Marius), vous proposent un menu à 6 mains autour des produits du Sud-Ouest.',
            'Les dimanche 2 et lundi 3 novembre 2014, de 10h à 19h, retrouvez des dizaines de vignerons et leurs vins actuels et naturels, venus de France, d’Italie ou même d’Argentine (et aussi un peu de bière et du café) lors de la première édition du salon Rue89 Lyon des vins.',
            'Cette année encore, ça se passe aux Grandes tables à la Friche belle de mai, à MARSEILLE. Le principe est simple, le verre en main, ballade dégustative pour découvrir les différentes cuvées des vignero(ne)s. Vous pourrez également acheter une soixantaine de cuvées à un prix unique de 10€ à un comptoir de vente à emporter, une cuvée par vigneron(ne).',
            'Après 2013, voici l\'édition 2014 ! Chez Triplettes, dégustation des nouvelles cuvées de Fleurie et Beaujolais du Domaine Yvon Métras avec pour cette année, le retour du Fleurie "Le Printemps".',
            'Après 2013, voici l\'édition 2014 ! Lors d\'un repas exceptionnel réalisé à l\'Amphitryon (Restaurant 2 étoiles Michelin à Colomiers), Yannick Delpech, Aziz Mokhtari (Les Petits Fayots) et Nicolas Brousse (Monsieur Marius), vous proposent un menu à 6 mains autour des produits du Sud-Ouest.',
            'Après 2013, voici l\'édition 2014 !Cette année encore, ça se passe aux Grandes tables à la Friche belle de mai, à MARSEILLE. Le principe est simple, le verre en main, ballade dégustative pour découvrir les différentes cuvées des vignero(ne)s. Vous pourrez également acheter une soixantaine de cuvées à un prix unique de 10€ à un comptoir de vente à emporter, une cuvée par vigneron(ne).',
            'C\'est une belle invitation printanière que lance Robert Plageoles. Le principe est simple, le visiteur apporte son panier pique-nique et pour accompagner le repas, le vigneron propose ses vins gratuitement à la dégustation.',
            );

        $authors = array('CB', 'CB', 'AH', 'CB', 'AH', 'CB', 'CB', 'CB');

        //$dates = array('13 Septembre 2013', '3 Avril 2013', '2 et 3 Novembre 2013', '30 et 31 Mars 2014', '20 Septembre 2014', '5 Avril 2013', '01 et 02 Avril 2014', '15 Juin 2014');

        $dateStarts = array(
            new \DateTime('2013-09-13'),
            new \DateTime('2013-04-03'),
            new \DateTime('2013-11-02'),
            new \DateTime('2014-03-30'),
            new \DateTime('2014-09-20'),
            new \DateTime('2013-04-05'),
            new \DateTime('2014-04-01'),
            new \DateTime('2014-06-15'),
            );

        $dateEnds = array(
            new \DateTime('2013-09-13'),
            new \DateTime('2013-04-03'),
            new \DateTime('2013-11-03'),
            new \DateTime('2014-03-31'),
            new \DateTime('2014-09-20'),
            new \DateTime('2013-04-05'),
            new \DateTime('2014-04-02'),
            new \DateTime('2014-06-15'),
            );

        //$years = array('2013', '2013', '2013', '2013', '2014', '2014', '2014', '2014');

        $tels = array(null, '05 61 15 55 55', null, '06 82 01 77 08 (Loïc) / 04 75 52 51 02 (Jocelyne) / 06 88 10 59 47 (Alain)', null, null, null, null);

        $hrefs = array(null, null, 'http://www.rue89lyon.fr/salondesvins', 'http://www.laremise.fr', null, null, null, null);

        $sites = array(null, null, 'rue89lyon.fr/salondesvins', 'laremise.fr', null, null, null, null);

        $openingHours = array(
                        'De 10h à 19h.',
                        'De 20h à minuit.',
                        'De 10h à 19h',
                        'De 10h30 à 19h le 30 Mars. De 10h30 à 17h le 31 Mars.',
                        'De 10h à 19h.',
                        'De 20h à minuit.',
                        'De 10h30 à 19h le 01 Avril. De 10h30 à 17h le 02 Avril.',
                        'De 11h à 16h',
                        );

        $useexttels = array(true, false, false, false, true, true, true, true);

        $useextsites = array(true, false, false, false, true, true, true, true);

        $namesen = array('Yvon Métras at Temps des Vendanges', 'Gourmet in Toulouse', 'Sous les pavés, la vigne !', 'La remise', 'Yvon Métras at Temps des Vendanges', 'Gourmet in Toulouse', 'La remise', 'Lunch on grass at Robert Plageoles');

        $descriptionsen = array(
            'At Temps des Vendanges, this Saturday, September 13, tasting new wines and Beaujolais Fleurie Domaine Yvon Métras this year with the return of Fleurie "Spring".',
            'During a special meal made ​​Amphitryon (2 Michelin star restaurant in Colomiers), Yannick Delpech, Aziz Mokhtari (Little baked beans) and Nicolas Brousse (Mr. Marius), offer a menu of six hands around Southern products Nighthawk.',
            'Sunday 2 and Monday, November 3, 2014, from 10h to 19h, find dozens of wineries and their current and natural wines from France, Italy or even Argentina (and some beer and coffee) at the first edition of Rue89 Lyon wine.',
            'This year, it happens to Large tables in the open Wasteland May in Marseilles. The principle is simple, glass in hand, walking dégustative to discover the different vintages of vignero (ne) s. You can also buy sixty wines at a single price of 10 € at a counter, take away, a wine by winemaker (do).',
            'After 2013, this is the 2014 edition! At Triplettes, tasting new wines and Beaujolais Fleurie Domaine Yvon Métras this year with the return of Fleurie "Spring".',
            'After 2013, this is the 2014 edition! During a special meal made ​​Amphitryon (2 Michelin star restaurant in Colomiers), Yannick Delpech, Aziz Mokhtari (Little baked beans) and Nicolas Brousse (Mr. Marius), offer a menu of six hands around Southern products Nighthawk.',
            'After 2013, this is the 2014 edition! Once again, it goes to the Large tables in the open Wasteland May in Marseilles. The principle is simple, glass in hand, walking dégustative to discover the different vintages of vignero (ne) s. You can also buy sixty wines at a single price of 10 € at a counter, take away, a wine by winemaker (do).',
            'It\'s a beautiful spring invitation launches Robert Plageoles. The principle is simple, the visitor is providing picnic and to accompany the meal, the winemaker offers free wines for tasting.',
            );

        //$datesen = array('September 13, 2013', 'April 3, 2013', '2 and 3 November, 2013', '30 and March 31, 2014', 'September 20, 2014', 'April 5 2014', '1 and April 2, 2014', 'June 15 2014');

        $openingHoursen = array(
                        'From 10am to 7pm.',
                        'De 8pm to noon.',
                        'From 10am to 7pm.',
                        'From 10:30am to 7pm on Mars 30. From 10:30am to 5pm on Mars 31.',
                        'From 10am to 7pm.',
                        'De 8pm to noon.',
                        'From 10:30am to 7pm on April 1. From 10:30am to 5pm on April 2.',
                        'From 11am to 16pm',
                        );

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($names as $i => $name) {
            $event[$i] = new Evt();
            $event[$i]->setName($name);
            $event[$i]->setPublication(true);

            $repository->translate($event[$i], 'name', 'en', $namesen[$i]);
        }

        foreach ($descriptions as $i => $description) {
            $event[$i]->setDescription($description);

            $repository->translate($event[$i], 'description', 'en', $descriptionsen[$i]);
        }

        foreach ($authors as $i => $author) {
            $event[$i]->setAuthor($author);
        }

        foreach ($dateStarts as $i => $dateStart) {
            $event[$i]->setDateStart($dateStart);

            //$repository->translate($event[$i], 'date', 'en', $datesen[$i]);
        }

        foreach ($dateEnds as $i => $dateEnd) {
            $event[$i]->setDateEnd($dateEnd);

            //$repository->translate($event[$i], 'date', 'en', $datesen[$i]);
        }

        //foreach ($years as $i => $year) {
        //    $event[$i]->setYear($year);
        //}

        foreach ($tels as $i => $tel) {
            $event[$i]->setTel($tel);
        }

        foreach ($hrefs as $i => $href) {
            $event[$i]->setHref($href);
        }

        foreach ($sites as $i => $site) {
            $event[$i]->setSite($site);
        }

        foreach ($useexttels as $i => $useexttel) {
            $event[$i]->setUseExtTel($useexttel);
        }

        foreach ($useextsites as $i => $useextsite) {
            $event[$i]->setUseExtSite($useextsite);
        }

        foreach ($openingHours as $i => $openingHour) {
            $event[$i]->setOpeningHours($openingHour);

            $repository->translate($event[$i], 'openingHours', 'en', $openingHoursen[$i]);

            $manager->persist($event[$i]);

            $this->addReference('event-'.$i, $event[$i]);

            $event[$i]->setImage($this->getReference('imageevent-'.$i));
        }

        $event[0]->setEventType($this->getReference('eventtype-0'));
        $event[0]->setRestaurant($this->getReference('restaurant-0'));

        $event[1]->setEventType($this->getReference('eventtype-3'));
        $event[1]->setCoordinates($this->getReference('coordinates-11'));

        $event[2]->setEventType($this->getReference('eventtype-1'));
        $event[2]->setCoordinates($this->getReference('coordinates-12'));

        $event[3]->setEventType($this->getReference('eventtype-1'));
        $event[3]->setCoordinates($this->getReference('coordinates-13'));

        $event[4]->setEventType($this->getReference('eventtype-0'));
        $event[4]->setRestaurant($this->getReference('restaurant-0'));

        $event[5]->setEventType($this->getReference('eventtype-3'));
        $event[5]->setEventPast($this->getReference('event-1'));

        $event[6]->setEventType($this->getReference('eventtype-1'));
        $event[6]->setEventPast($this->getReference('event-3'));

        $event[7]->setEventType($this->getReference('eventtype-3'));
        $event[7]->setWinemakerDomain($this->getReference('winemakerdomain-4'));

        $manager->flush();
    }

    public function getOrder()
    {
        return 502; // l'ordre dans lequel les fichiers sont chargés
    }
}
