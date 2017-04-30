<?php

namespace FBN\GuideBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FBN\GuideBundle\Entity\EventRepository;

class AdminController extends BaseAdminController
{
    /**
     * Language switcher.
     *
     * @param null|string $locale the locale
     *
     * @return RedirectResponse the response
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

        return $this->redirectToRouteForDefaultLocaleIfNeeded($response);
    }

    /*
     * {@inheritdoc}
     *
     * If current entity is User force edition to be executed in default locale.
     */
    protected function editAction()
    {
        $response = parent::editAction();

        if ('User' === $this->get('request')->query->get('entity')) {
            return $this->redirectToRouteForDefaultLocaleIfNeeded($response);
        }

        return $response;
    }

    /*
     * {@inheritdoc}
     *
     * Restaurant : Disable non translatable fields for locale different of default locale.
     */
    protected function createRestaurantEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        return $this->getFormBuilderForNonDefaultLocale($formBuilder, $entity, $view);
    }

    /*
     * {@inheritdoc}
     *
     * Winemaker : Remove non translatable fields for locale different of default locale.
     */
    protected function createWinemakerEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        return $this->getFormBuilderForNonDefaultLocale($formBuilder, $entity, $view);
    }

    /*
     * {@inheritdoc}
     *
     * Shop : Disable non translatable fields for locale different of default locale.
     */
    protected function createShopEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        return $this->getFormBuilderForNonDefaultLocale($formBuilder, $entity, $view);
    }

    /*
     * {@inheritdoc}
     *
     * Info : Disable non translatable fields for locale different of default locale.
     */
    protected function createInfoEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        return $this->getFormBuilderForNonDefaultLocale($formBuilder, $entity, $view);
    }

    /*
     * {@inheritdoc}
     *
     * Tutorial : Disable non translatable fields for locale different of default locale.
     */
    protected function createTutorialEntityFormBuilder($entity, $view)
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
     * - Do not self reference the event in drop down (edition only) and show only event with non null coordinates.
     */
    protected function createEventEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);
        $defaulLocale = $this->container->getParameter('locale');

        if ($this->get('request')->getLocale() === $defaulLocale) {
            $formBuilder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                $data = $event->getData();

                if ((null !== $data->getRestaurant()) || (null !== $data->getShop()) || (null !== $data->getWinemakerDomain()) || (null !== $data->getEventPast())) {
                    $data->setCoordinates(null);
                }

                $event->setData($data);
            });
        }

        // If it's a new entity, id is null.
        $id = (null !== $entity->getId()) ? $entity->getId() : 0;
        $formBuilder->add('eventPast', EntityType::class, array(
            'class' => 'FBNGuideBundle:Event',
            'query_builder' => function (EventRepository $repo) use ($id) {
                return $repo->getEventsWithCoordinatesAndExcludedId($id);
            },
            'attr' => ['data-widget' => 'select2'],
            'placeholder' => 'label.form.empty_value',
            'required' => false,
            )
        );

        return $this->getFormBuilderForNonDefaultLocale($formBuilder, $entity, $view);
    }

    /**
     * {@inheritdoc}
     *
     * FOS User integration : user creation.
     */
    protected function createNewUserEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    /**
     * {@inheritdoc}
     *
     * FOS User integration : let Doctrine take of persisting the user.
     */
    protected function prePersistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    /**
     * {@inheritdoc}
     *
     * FOS User integration : let Doctrine take of updating the user.
     */
    protected function preUpdateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }

    protected function getFormBuilderForNonDefaultLocale($formBuilder, $entity, $view)
    {
        $entityName = $this->getEntityFormOptions($entity, $view)['entity'];
        $fieldsToBeDisabled = $this->config['entities'][$entityName]['form']['fields_to_be_disabled_for_non_default_locale'];

        $this->get('fbn_guide.form_manager')->disableNonTranslatableFormFieldsForNonDefaultLocale(
            $formBuilder,
            $fieldsToBeDisabled,
            $this->get('request')->getLocale())
        ;

        return $formBuilder;
    }

    /**
     * Redirect to route for default locale if needed (in case the locale is not the default one).
     *
     * @param Response $response the response from the default action (AdminController)
     *
     * @return RedirectResponse the response with default locale as locale
     */
    protected function redirectToRouteForDefaultLocaleIfNeeded($response)
    {
        $defaultLocale = $this->container->getParameter('locale');

        if ($defaultLocale !== $this->get('request')->getLocale()) {
            $locale = array('_locale' => $defaultLocale);
            $queryParams = $this->get('request')->query->all();
            $params = array_merge($locale, $queryParams);

            return $this->redirectToRoute('easyadmin', $params);
        }

        return $response;
    }
}
