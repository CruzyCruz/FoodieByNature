<?php

namespace FBN\GuideBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use FBN\GuideBundle\Entity\Shop as Shp;

class Shop extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $names = array('Vinea', 'Le Tire Bouchon', 'Les Caves Augé', 'Les Zinzins du Vin');

        $descriptionsfr = array(null, null, null, null);

        $owners = array('Jérôme Rey', 'Philippe Lagarde', 'Christian Constant', 'Thierry Marx');

        $hrefs = array('http://www.cave-vinea.com/', 'http://le-tire-bouchon.org/', 'http://www.cavesauge.com/', 'http://www.leszinzinsduvin.com/');

        $tels = array('05 34 27 17 75', '05 61 63 49 01', '01 45 22 16 97', '03 81 81 24 74');

        $sites = array('cave-vinea.com', 'le-tire-bouchon.org', 'cavesauge.com', 'leszinzinsduvin.com');

        $openingHours = array(
                        'De midi à 14h30 et de 19h à 23h. Fermé dimanche.',
                        'De 19h à 22h30. Fermé dimanche et lundi.',
                        'De midi à 14h30 (sauf samedi) et de 19h30 à 23h. Fermé dimanche. ',
                        'Tous les jours, de 11h30 à 15h et de 19h30 à 22h30 (22h le dimanche).',
                        );

        $descriptions = array('shop', 'shop', 'shop', 'shop');

        $openingHoursfr = array(
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

            $repository->translate($shop[$i], 'description', 'fr', $descriptionsfr[$i]);
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

            $repository->translate($shop[$i], 'openingHours', 'fr', $openingHoursfr[$i]);

            $manager->persist($shop[$i]);

            $shop[$i]->setCoordinates($this->getReference('coordinates-'.($i + 14)));

            $shop[$i]->setArticleOwner($this->getReference('user-0'));
            $shop[$i]->setArticleAuthor($this->getReference('user-0')->getAuthorName());

            $slugManager = $this->container->get('fbn_guide.slug_manager');
            $slugFromCoordinatesISO = $slugManager->getSlugFromCoordinatesISO(null, $this->getReference('coordinates-'.($i + 14)));
            $shop[$i]->setSlugFromCoordinatesISO($slugFromCoordinatesISO);

            $this->addReference('shop-'.$i, $shop[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 201;
    }
}
