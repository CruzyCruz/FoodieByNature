<?php

namespace FBN\GuideBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\RestaurantStyle as RestrntStyle;

class RestaurantStyle extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $stylesfr = array('Cave à Manger', 'Bistronomie', 'Masterchef', 'Street Food');

        $styles = array('Wine bar', 'Bistronomy', 'Masterchef', 'Street Food');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($styles as $i => $style) {
            $restaurantstyle[$i] = new RestrntStyle();
            $restaurantstyle[$i]->setStyle($style);

            $repository->translate($restaurantstyle[$i], 'style', 'fr', $stylesfr[$i]);

            $manager->persist($restaurantstyle[$i]);

            $this->addReference('restaurantstyle-'.$i, $restaurantstyle[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 303;
    }
}
