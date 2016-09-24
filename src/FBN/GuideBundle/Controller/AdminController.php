<?php

namespace FBN\GuideBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FBN\GuideBundle\Entity\EventRepository;

class AdminController extends BaseAdminController
{
    /**
     * Language switcher.
     *
     * @param null|string $locale The locale.
     *
     * @return RedirectResponse The response.
     */
    public function switchLocaleAction($locale = null)
    {
        if (null === $locale) {
            $locale = $this->get('request')->getLocale();
        }

        $params = $this->get('request')->getSession()->get('lastRouteData')['params'];
        $params['_locale'] = $locale;

        return $this->redirectToRoute('easyadmin', $params);
    }

    /*
     * {@inheritdoc}
     * 
     * Force all new action to be executed in default locale.
     */
    protected function newAction()
    {
        $response = parent::newAction();

        $defaultLocale = $this->container->getParameter('locale');

        if ($defaultLocale !== $this->get('request')->getLocale()) {
            $locale = array('_locale' => $defaultLocale);
            $queryParams = $this->get('request')->query->all();
            $params = array_merge($locale, $queryParams);

            return $this->redirectToRoute('easyadmin', $params);
        }

        return $response;
    }

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

        return $this->getFormBuilderForNonDefaultLocale($formBuilder, $entity, $view);
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

        // Only in case of edition : do not self-reference event in events list.
        if (null !== $id = $entity->getId()) {
            $formBuilder->add('eventPast', EntityType::class, array(
                'class' => 'FBNGuideBundle:Event',
                'query_builder' => function (EventRepository $repo) use ($id) {

                    return $repo->getEventsWithExcludedId($id);
                    },
                'attr' => ['data-widget' => 'select2'],
                'placeholder' => 'label.form.empty_value',
                'required' => false,
                ));
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
