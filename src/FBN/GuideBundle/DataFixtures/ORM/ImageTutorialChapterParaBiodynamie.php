<?php

// src/FBN/GuideBundle/DataFixtures/ORM/ImageTutorialChapterParaBiodyamie.php

namespace FBN\GuideBundle\DataFixtures\ORM;

use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\ImageTutorialChapterPara as Image;

class ImageTutorialChapterParaBiodynamie extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $ranks = array(0, 0, 0);

        $path = __DIR__.'/Resources/Images/tutorials/';
        $pathto = __DIR__.'/../../../../../web/uploads/images/tutorials/';

        $names = array('tutorial-la-biodynamie-c0-p0-i0.jpg', 'tutorial-la-biodynamie-c1-p0-i0.jpg', 'tutorial-la-biodynamie-c2-p0-i0.jpg');

        $legendsfr = array('Les buts de l’agriculture biodynamique', 'Historique de l’agriculture biodynamique en France', 'Historique de l’agriculture biodynamique dans le monde');

        $legends = array('The goals of biodynamic agriculture', 'History biodynamic agriculture in France', 'Organic wines');

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

            $this->addReference('imagetutorialchapterparabiodynamie-'.$i, $imagetutorialcp[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 107; // l'ordre dans lequel les fichiers sont chargés
    }
}
