<?php

namespace FBN\GuideBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use FBN\GuideBundle\Form\WinemakerDomainType;

class AdminController extends BaseAdminController
{
    /*
     * {@inheritdoc}
     * 
     * Restaurant : Disable non translatable fields for locale different of default locale.
     */
    public function createRestaurantEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        return $this->getFormBuilderForNonDefaultLocale($formBuilder, $entity, $view);
    }

    /*
     * {@inheritdoc}
     * 
     * Winemaker : Remove non translatable fields for locale different of default locale.
     */
    public function createWinemakerEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        $formBuilder->add('winemakerDomain', CollectionType::class, array(
                'entry_type' => WinemakerDomainType::class,
                'by_reference' => false,
                'entry_options' => array(
                    'locale' => $this->get('request')->getLocale(),
                    ),
                )
            )
        ;

        return $formBuilder;
    }

    /*
     * {@inheritdoc}
     * 
     * Shop : Disable non translatable fields for locale different of default locale.
     */
    public function createShopEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        return $this->getFormBuilderForNonDefaultLocale($formBuilder, $entity, $view);
    }

    /*
     * {@inheritdoc}
     * 
     * Info : Disable non translatable fields for locale different of default locale.
     */
    public function createInfoEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        return $this->getFormBuilderForNonDefaultLocale($formBuilder, $entity, $view);
    }

    /*
     * {@inheritdoc}
     * 
     * Tutorial : Disable non translatable fields for locale different of default locale.
     */
    public function createTutorialEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        return $this->getFormBuilderForNonDefaultLocale($formBuilder, $entity, $view);
    }

    /*
     * {@inheritdoc}
     *
     * Event:
     * - Set coordinates to null in Event entity when an alternatative is proposed (restaurant, shop... - only for default locale)
     * - Disable non translatable fields for locale different of default locale.
     */
    public function createEventEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);
        $defaulLocale = $this->container->getParameter('locale');

        if ($this->get('request')->getLocale() === $defaulLocale) {
            $formBuilder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                $data = $event->getData();

                if ((null !== $data->getRestaurant())  || (null !== $data->getShop()) || (null !== $data->getWinemakerDomain()) || (null !== $data->getEventPast())) {
                    $data->setCoordinates(null);
                }

                $event->setData($data);
            });
        }

        return $this->getFormBuilderForNonDefaultLocale($formBuilder, $entity, $view);
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

    public function getFormBuilderForNonDefaultLocale($formBuilder, $entity, $view)
    {
        $entityName = $this->getEntityFormOptions($entity, $view)['entity'];
        $fieldsToBeDisabled = $this->config['entities'][$entityName]['form']['fields_to_be_disabled_for_non_default_locale'];

        $this->get('fbn_guide.translation_manager')->disableNonTranslatableFormFieldsForNonDefaultLocale(
            $formBuilder,
            $fieldsToBeDisabled,
            $this->get('request')->getLocale())
        ;

        return $formBuilder;
    }
}
