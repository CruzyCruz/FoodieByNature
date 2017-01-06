<?php

namespace FBN\GuideBundle\DataFixtures\ORM;

use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\ImageTutorialChapterPara as Image;

class ImageTutorialChapterParaVinNaturel extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $ranks = array(0, 0, 0, 0);

        $path = __DIR__.'/Resources/Images/tutorials/';
        $pathto = __DIR__.'/../../../../../web/uploads/images/tutorials/';

        $names = array('tutorial-le-vin-au-naturel-c0-p0-i0.jpg', 'tutorial-le-vin-au-naturel-c1-p1-i1.jpg', 'tutorial-le-vin-au-naturel-c2-p2-i2.jpg', 'tutorial-le-vin-au-naturel-c3-p3-i3.jpg');

        $legendsfr = array('Le terroir', 'C\'est quoi un vin naturel ?', 'Les vins bio', 'La viticulture biodynamique');

        $legends = array('The terroir', 'What is a natural wine?', 'Organic wines', 'Biodynamic viticulture');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($ranks as $i => $rank) {
            $imagetutorialcp[$i] = new Image();
            $imagetutorialcp[$i]->setRank($rank);
        }

        foreach ($names as $i => $name) {
            $imagetutorialcp[$i]->setName($name);
            copy($path.$name, $pathto.$name);
            $image = new File($pathto.$name);
            $imagetutorialcp[$i]->setFile($image);
        }

        foreach ($legends as $i => $legend) {
            $imagetutorialcp[$i]->setLegend($legend);

            $repository->translate($imagetutorialcp[$i], 'legend', 'fr', $legendsfr[$i]);

            $manager->persist($imagetutorialcp[$i]);

            $this->addReference('imagetutorialchapterparavinnaturel-'.$i, $imagetutorialcp[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 106;
    }
}
