<?php
// src/FBN/UserBundle/DataFixtures/ORM/User.php

namespace FBN\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class User implements FixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;
    

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {

    $userManager = $this->container->get('fos_user.user_manager');


    $listNames = array('Cedric');

    foreach ($listNames as $name) 
    {

      $user = $userManager->createUser();
      
      $user->setUsername($name);

      $user->setPlainPassword($name);

      $user->setEmail('bonnin.cedric@gmail.com');


      $user->setRoles(array('ROLE_USER'));
      
      $user->setEnabled(true);    

      $userManager->updateUser($user, true);  

      // On le persiste
      //$manager->persist($user);
    }

    // On déclenche l'enregistrement
    //$manager->flush();
    }
}