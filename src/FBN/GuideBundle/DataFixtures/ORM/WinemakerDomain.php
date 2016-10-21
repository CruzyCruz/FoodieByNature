<?php

// src/FBN/GuideBundle/DataFixtures/ORM/WinemakerDomain.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use FBN\GuideBundle\Entity\WinemakerDomain as WmkrDmn;

class WinemakerDomain extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $domains = array('Domaine Léon Barral', 'Domaine des Chênes', '', 'Domaine Très Cantous', 'Domaine Roucou-Cantemerle', '');

        $hrefs = array('http://www.domainleonbarral.com', 'http://www.marcel-lapierre.com', 'http://http://www.eliandaros.fr', 'http://www.vins-plageoles.com', 'http://www.vins-plageoles.com', 'http://www.selosse-lesavises.com');

        $tels = array('04 67 90 29 13', '04 74 04 23 89', '05 53 20 75 22', '05 63 33 90 40', '05 68 38 95 45', '03 26 57 53 56');

        $sites = array('domaineleonbarral.com', 'marcel-lapierre.com', 'eliandaros.fr', 'vins-plageoles.com', 'vins-plageoles.com', 'selosse-lesavises.com');

        $openingHours = array(
                        'Tous les jours, de 8h à 18h.',
                        'De midi à 19h. Fermé dimanche.',
                        'De midi à 18h. Fermé dimanche et lundi.',
                        'Tous les jours, de 8h à 20h.',
                        'Tous les jours, de 8h à 20h.',
                        'Tous les jours, de 8h à 12h et de 14h à 19h.',
                        );

        $openingHoursen = array(
                        'Everyday, from 8am to 6pm.',
                        'From noon to 7pm. Closed Sunday.',
                        'From noon to 8pm. Closed Sunday and Monday.',
                        'Everyday, from 8am to 8pm.',
                        'Everyday, from 8am to 8pm.',
                        'Everyday, from 8am to 12pm and from 14pm to 19pm.',
                        );

        $winemaker_ids = array(
            1,
            2,
            3,
            4,
            4,
            5,
            );

        $winemakerarea_ids = array(
            10,
            3,
            15,
            15,
            15,
            7,
            );

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($domains as $i => $domain) {
            $wmkrDmn[$i] = new WmkrDmn();
            $wmkrDmn[$i]->setDomain($domain);
        }

        foreach ($hrefs as $i => $href) {
            $wmkrDmn[$i]->setHref($href);
        }

        foreach ($tels as $i => $tel) {
            $wmkrDmn[$i]->setTel($tel);
        }

        foreach ($sites as $i => $site) {
            $wmkrDmn[$i]->setSite($site);
        }

        foreach ($openingHours as $i => $openingHour) {
            $wmkrDmn[$i]->setOpeningHours($openingHour);

            $repository->translate($wmkrDmn[$i], 'openingHours', 'en', $openingHoursen[$i]);

            $manager->persist($wmkrDmn[$i]);

            $wmkrDmn[$i]->setWinemaker($this->getReference('winemaker-'.($winemaker_ids[$i] - 1)));
            $wmkrDmn[$i]->setWinemakerArea($this->getReference('winemakerarea-'.($winemakerarea_ids[$i] - 1)));
            $wmkrDmn[$i]->setCoordinates($this->getReference('coordinates-'.($i + 5)));

            $slugManager = $this->container->get('fbn_guide.slug_manager');
            $slugFromCoordinatesISO = $slugManager->getSlugFromCoordinatesISO(null, $this->getReference('coordinates-'.($i + 5)));
            $wmkrDmn[$i]->setSlugFromCoordinatesISO($slugFromCoordinatesISO);

            $this->addReference('winemakerdomain-'.$i, $wmkrDmn[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 403; // l'ordre dans lequel les fichiers sont chargés
    }
}
