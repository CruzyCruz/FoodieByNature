<?php

// src/FBN/GuideBundle/DataFixtures/ORM/Menu.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use FBN\GuideBundle\Entity\Menu as Mnu;

class Menu extends AbstractFixture implements OrderedFixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        $sections = array('Info', 'Restaurant', 'Winemaker', 'Event', 'Tutorial', 'Shop', 'Bookmark');

        $introsfr = array('Mais qu\'est ce qui se passe ?', 'La crème de la crème des tables au naturel', 'L\'élite', 'Ca se passe où et quand ?', 'Naturel kezako ?', 'Les rois du goulot', '');

        $intros = array('What the fuck?', 'La crème de la crème of natural restaurants', 'The elite', 'Where it is and when it is?', 'Natural kezako ?', 'Kings of bottleneck', '');

        $titlesfr = array('Infos', 'Restaurants', 'Vignerons', 'Evénements', 'Tutoriaux', 'Cavistes', 'Mes favoris');

        $titles = array('Infos', 'Restaurants', 'Winemakers', 'Events', 'Tutorials', 'Shops', 'My bookmarks');

        $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        foreach ($sections as $i => $section) {
            $menu[$i] = new Mnu();
            $menu[$i]->setSection($section);
        }

        foreach ($titles as $i => $title) {
            $menu[$i]->setTitle($title);

            $repository->translate($menu[$i], 'title', 'fr', $titlesfr[$i]);
        }

        foreach ($intros as $i => $intro) {
            $menu[$i]->setIntro($intro);

            $repository->translate($menu[$i], 'intro', 'fr', $introsfr[$i]);

            $manager->persist($menu[$i]);

            $this->addReference('menu-'.$i, $menu[$i]);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1001; // l'ordre dans lequel les fichiers sont chargés
    }
}
