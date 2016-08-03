<?php

namespace FBN\GuideBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AdminController extends BaseAdminController
{
    /*
     * {@inheritdoc}
     *
     * Set coordinates to null in Event entity when an alternatative is proposed (restaurant, shop...)
     */
    public function createEventEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        $formBuilder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $data = $event->getData();

            if ((null !== $data->getRestaurant())  || (null !== $data->getShop()) || (null !== $data->getWinemakerDomain()) || (null !== $data->getEventPast())) {
                $data->setCoordinates(null);
            }

            $event->setData($data);
        });

        return $formBuilder;
    }

    /**
     * {@inheritdoc}
     * 
     * FOS User integration : user creation.     
     */
    public function createNewUserEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    /**
     * {@inheritdoc}
     * 
     * FOS User integration : let Doctrine take of persisting the user.     
     */
    public function prePersistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    /**
     * {@inheritdoc}
     * 
     * FOS User integration : let Doctrine take of updating the user.     
     */
    public function preUpdateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }
}
