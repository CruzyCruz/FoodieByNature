<?php

namespace FBN\GuideBundle\DataFixtures\ORM;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\ImageRestaurant as Image;

class ImageRestaurant extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $ranks = array(0, 0, 0, 0, 0);

        $path = __DIR__.'/Resources/Images/restaurants/';
        $pathto = __DIR__.'/../../../../../web/uploads/images/restaurants/';

        // First delete all files in target directory
        $files = glob($pathto.'/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        // Clean cache (whole cache as this file is the first loaded for images fixtures)
        $cacheManager = $this->container->get('liip_imagine.cache.manager');
        $cacheManager->remove();

        $names = array('restaurant-paris-triplettes-il.jpg', 'restaurant-paris-naturellement-il.jpg', 'restaurant-paris-la-fine-mousse-il.jpg', 'restaurant-paris-dix-huit-il.jpg', 'restaurant-paris-cantine-california-il.jpg');

        $legendsfr = array('Plutôt trois fois qu\'une', 'Nature, quoi d\'autre ?', 'So bière!', '18 (dix-huit)', 'Si tu viens to San Fransisco...');

        $legends = array('Three times better than one', 'Nature, what else ?', 'So beer!', '18 (eigtheen)', 'If you come to San Fransisco...');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($ranks as $i => $rank) {
            $imagerestaurant[$i] = new Image();
            $imagerestaurant[$i]->setRank($rank);
        }

        foreach ($names as $i => $name) {
            $imagerestaurant[$i]->setName($name);
            copy($path.$name, $pathto.$name);
            $image = new File($pathto.$name);
            $imagerestaurant[$i]->setFile($image);
        }

        foreach ($legends as $i => $legend) {
            $imagerestaurant[$i]->setLegend($legend);

            $repository->translate($imagerestaurant[$i], 'legend', 'fr', $legendsfr[$i]);

            $manager->persist($imagerestaurant[$i]);

            $this->addReference('imagerestaurant-'.$i, $imagerestaurant[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 102;
    }
}
