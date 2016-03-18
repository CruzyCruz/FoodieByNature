<?php

// src/FBN/GuideBundle/DataFixtures/ORM/Shop.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Shop as Shp;

class Shop extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $names = array(null, 'Vinea', 'Le Tire Bouchon', 'Les Caves Augé', 'Les Zinzins du Vin');

        $descriptions = array(null, null, null, null, null);

        $authors = array('CB', 'AH', 'CB', 'AH', 'AH');

        $owners = array(null, 'Jérôme Rey', 'Philippe Lagarde', 'Christian Constant', 'Thierry Marx');

        $hrefs = array(null, 'http://www.cave-vinea.com/', 'http://le-tire-bouchon.org/', 'http://www.cavesauge.com/', 'http://www.leszinzinsduvin.com/');

        $tels = array(null, '05 34 27 17 75', '05 61 63 49 01', '01 45 22 16 97', '03 81 81 24 74');

        $sites = array(null, 'cave-vinea.com', 'le-tire-bouchon.org', 'cavesauge.com', 'leszinzinsduvin.com');

        $openingHours = array(
                        'Tous les jours, de 8h à 1h30 ; service de midi à 15h30 et de 19h à 23h30.',
                        'De midi à 14h30 et de 19h à 23h. Fermé dimanche.',
                        'De 19h à 22h30. Fermé dimanche et lundi.',
                        'De midi à 14h30 (sauf samedi) et de 19h30 à 23h. Fermé dimanche. ',
                        'Tous les jours, de 11h30 à 15h et de 19h30 à 22h30 (22h le dimanche).',
                        );

        $descriptionsen = array(null, null, null, null, null);

        $openingHoursen = array(
                        'Everyday, from 8am to 1:30am; meal service from noon to 3:30pm and from 7pm to 11:30pm.',
                        'From noon to 2:30pm and from 7pm to 11pm. Closed Sunday.',
                        'From 7pm to 10:30pm. Closed Sunday and Monday.',
                        'From noon to 2:30pm (except Saturday) and from 7:30pm to 11pm. Closed Sunday.',
                        'Everyday, from 11:30am to 3pm and from 7:30pm to 10:30pm (10pm Sunday).',
                        );

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($names as $i => $name) {
            $shop[$i] = new Shp();
            $shop[$i]->setName($name);
            $shop[$i]->setPublication(true);
        }

        foreach ($descriptions as $i => $description) {
            $shop[$i]->setDescription($description);

            $repository->translate($shop[$i], 'description', 'en', $descriptionsen[$i]);
        }

        foreach ($authors as $i => $author) {
            $shop[$i]->setAuthor($author);
        }

        foreach ($owners as $i => $owner) {
            $shop[$i]->setOwner($owner);
        }

        foreach ($hrefs as $i => $href) {
            $shop[$i]->setHref($href);
        }

        foreach ($tels as $i => $tel) {
            $shop[$i]->setTel($tel);
        }

        foreach ($sites as $i => $site) {
            $shop[$i]->setSite($site);
        }

        foreach ($openingHours as $i => $openingHour) {
            $shop[$i]->setOpeningHours($openingHour);

            $repository->translate($shop[$i], 'openingHours', 'en', $openingHoursen[$i]);

            $manager->persist($shop[$i]);

            if ($i != 0) {
                $shop[$i]->setCoordinates($this->getReference('coordinates-'.($i + 13)));
            }

            $this->addReference('shop-'.$i, $shop[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 201; // l'ordre dans lequel les fichiers sont chargés
    }
}
