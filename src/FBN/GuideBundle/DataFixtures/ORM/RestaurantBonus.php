<?php

// src/FBN/GuideBundle/DataFixtures/ORM/RestaurantBonus.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\RestaurantBonus as RestrntBonus;

class RestaurantBonus extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $bonussfr = array('Terrasse', 'Jardin', 'Ouvert le dimanche', 'Faim de nuit');

        $bonuss = array('Terrace', 'Garden', 'Open sunday', 'Late night hunger');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($bonuss as $i => $bonus) {
            $restaurantbonus[$i] = new RestrntBonus();
            $restaurantbonus[$i]->setBonus($bonus);

            $repository->translate($restaurantbonus[$i], 'bonus', 'fr', $bonussfr[$i]);

            $manager->persist($restaurantbonus[$i]);

            $this->addReference('restaurantbonus-'.$i, $restaurantbonus[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 301; // l'ordre dans lequel les fichiers sont chargés
    }
}
