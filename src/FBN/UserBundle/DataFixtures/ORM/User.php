<?php

// src/FBN/UserBundle/DataFixtures/ORM/User.php

namespace FBN\UserBundle\DataFixtures\ORM;

//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class User extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $listNames = array('Cedric');

        foreach ($listNames as $i => $name) {
            $user[$i] = $userManager->createUser();

            $user[$i]->setUsername($name);

            $user[$i]->setPlainPassword($name);

            $user[$i]->setEmail('bonnin.cedric@gmail.com');

            $user[$i]->setRoles(array('ROLE_ADMIN'));

            $user[$i]->setEnabled(true);

            $user[$i]->setAuthorName('C.B.');

            $userManager->updateUser($user[$i], true);

            $this->addReference('user-'.$i, $user[$i]);

      // On le persiste
      //$manager->persist($user);
        }

    // On déclenche l'enregistrement
    //$manager->flush();
    }

    public function getOrder()
    {
        return 1; // l'ordre dans lequel les fichiers sont chargés
    }
}
