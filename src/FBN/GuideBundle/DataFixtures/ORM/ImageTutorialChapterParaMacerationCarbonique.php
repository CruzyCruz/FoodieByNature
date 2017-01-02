<?php

// src/FBN/GuideBundle/DataFixtures/ORM/ImageTutorialChapterParaMacerationCarbonique.php

namespace FBN\GuideBundle\DataFixtures\ORM;

use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\ImageTutorialChapterPara as Image;

class ImageTutorialChapterParaMacerationCarbonique extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $ranks = array(0, 0, 0);

        $path = __DIR__.'/Resources/Images/tutorials/';
        $pathto = __DIR__.'/../../../../../web/uploads/images/tutorials/';

        $names = array('tutorial-la-maceration-carbonique-c0-p0-i0.jpg', 'tutorial-la-maceration-carbonique-c1-p0-i0.jpg', 'tutorial-la-maceration-carbonique-c2-p0-i0.jpg');

        $legendsfr = array('Théorie', 'Mise en œuvre', 'Produits obtenus');

        $legends = array('Theory', 'Implementation', 'Products obtained');

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

            $this->addReference('imagetutorialchapterparamacerationcarbonique-'.$i, $imagetutorialcp[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 109; // l'ordre dans lequel les fichiers sont chargés
    }
}
