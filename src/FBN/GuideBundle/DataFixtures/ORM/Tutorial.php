<?php

// src/FBN/GuideBundle/DataFixtures/ORM/Tutorial.php

namespace FBN\GuideBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use FBN\GuideBundle\Entity\Tutorial as Tuto;

class Tutorial extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $namesfr = array('Le vin au naturel', 'La biodynamie', 'Les labels', 'La macération carbonique', 'Boire nature');

        $descriptionsfr = array(
            'Il existe en France environ 3000 vignerons, soit moins de 3% à l’échelle nationale, qui travaillent en bio, biodynamie ou de manière naturelle se démarquant ainsi des pratiques productivistes. Pour des raisons éthiques, ces vignerons ont choisi de travailler en utilisant des pratiques respectueuses de l’environnement ayant pour objectif de retrouver l’expression naturelle des terroirs et le caractère vivant du vin.',
            'L’agriculture biodynamique est une agriculture assurant la santé du sol et des plantes pour procurer une alimentation saine aux animaux et aux Hommes. Elle se base sur une profonde compréhension des lois du « vivant » acquise par une vision qualitative/globale de la nature. Elle considère que la nature est actuellement tellement dégradée qu’elle n’est plus capable de se guérir elle-même et qu’il est nécessaire de redonner au sol sa vitalité féconde indispensable à la santé des plantes, des animaux et des Hommes grâce à des procédés thérapeutiques.',
            'AB, AOC, AOP, en cette période de rentrée, Oui Le Blog vous invite à réviser l’alphabet et à découvrir ce que garantissent labels et mentions de qualité. On vous prévient, on prévoit une interro-surprise en février.',
            'La macération carbonique est une technique de vinification de vin rouge primeur essentiellement, mais elle convient également à l’obtention de vin de garde. Elle a été initiée en France par Michel Flanzy 1 et perfectionnée à travers les expérimentations de Jules Chauvet.',
            'Non stabilisés, les vins naturels sont des vins vivants dont le goût et l’expression évoluent pendant la dégustation. A ce titre, ils peuvent parfois « déstabiliser » les amateurs de vins classiques.',
            );

        $names = array('The natural wine', 'Biodynamics', 'Labels', 'Carbonic maceration', 'Drink Nature');

        $descriptions = array(
            'There are about 3,000 wineries in France, less than 3% nationally, working in organic, biodynamic or naturally consequently achieve productivist practices. For ethical reasons, these wineries have chosen to work using environmentally friendly practices with the goal of finding the natural expression of terroir and character of the wine alive.',
            'Biodynamic agriculture is a farming ensuring the health of soil and plants to provide healthy food to animals and men. It is based on a deep understanding of the laws of the "living" acquired by a qualitative / holistic view of nature. She believes that nature is now so degraded that it is no longer able to heal itself and it is necessary to restore the soil to its essential plant health fruitful vitality, animals and men through therapeutic methods.',
            'AB, AOC, AOP, in this period of re-entry, Yes Blog invites you to review the alphabet and discover that ensure labels and quality terms. Be warned, it is expected interro surprise in February.',
            'Carbonic maceration is a winemaking technique primeur red wine mainly, but it is also suitable for the production of wine for aging. It was initiated in France by Michel Flanzy 1 and refined through experiments Jules Chauvet.',
            'Not stabilized, natural wines are living wines that taste and expression change during the tasting. As such, they can sometimes "destabilize" lovers of classic wines.',
            );

        $tutorialsection_ids = array(
            1,
            1,
            1,
            3,
            2,
            );

        foreach ($names as $i => $name) {
            $tutorial[$i] = new Tuto();
            $tutorial[$i]->setName($name);
        }

        foreach ($descriptions as $i => $description) {
            $tutorial[$i]->setDescription($description);
            $tutorial[$i]->setPublication(true);

            $tutorial[$i]->setArticleOwner($this->getReference('user-0'));
            $tutorial[$i]->setArticleAuthor($this->getReference('user-0')->getAuthorName());

            $manager->persist($tutorial[$i]);

            $this->addReference('tutorial-'.$i, $tutorial[$i]);

            $tutorial[$i]->setTutorialSection($this->getReference('tutorialsection-'.($tutorialsection_ids[$i] - 1)));
            $tutorial[$i]->setImage($this->getReference('imagetutorial-'.$i));
        }

        $manager->flush();

        // Translations managed after entities persistence in default locale (first flushing) for slug translation
        // It is needed to call translatable listener and change the locale before setting translatable fields
        // This way, slug is automatically translated
        unset($tutorial);

        $repositoryTuto = $manager->getRepository('FBNGuideBundle:Tutorial');
        $tutorials = $repositoryTuto->findAll();

        $translatableListener = $this->container->get('stof_doctrine_extensions.listener.translatable');

        // Locale : fr
        $translatableListener->setTranslatableLocale('fr');

        // No need to access translations repository and use translae() method 
        // as locale was directly changed in tanslatable listener i.e:
        // $repository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');
        // $repository->translate($tutorial, 'name', 'fr', $namesfr[$i]);        
        foreach ($tutorials as $i => $tutorial) {
            $tutorial->setName($namesfr[$i]);
            $tutorial->setDescription($descriptionsfr[$i]);
        }

        $manager->flush();

        // Reset translatable locale to default locale.
        $translatableListener->setTranslatableLocale($this->container->getParameter('locale'));
    }

    public function getOrder()
    {
        return 702; // l'ordre dans lequel les fichiers sont chargés
    }
}
