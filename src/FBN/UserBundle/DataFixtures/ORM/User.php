<?php

namespace FBN\UserBundle\DataFixtures\ORM;

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

        $listNames = array('admin', 'author', 'user');

        $roles = array(
            array('ROLE_ADMIN'),
            array('ROLE_AUTHOR'),
            array('ROLE_USER'),
            );

        $authorNames = array(
            'AD.MIN',
            'AU.THOR',
            'US.ER',
            );

        foreach ($listNames as $i => $name) {
            $user[$i] = $userManager->createUser();
            $user[$i]->setUsername($name);
            $user[$i]->setPlainPassword($name);
            $user[$i]->setEmail($name.'@fake.com');
            $user[$i]->setRoles($roles[$i]);
            $user[$i]->setEnabled(true);
            $user[$i]->setAuthorName($authorNames[$i]);

            $userManager->updateUser($user[$i], true);

            $this->addReference('user-'.$i, $user[$i]);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}
