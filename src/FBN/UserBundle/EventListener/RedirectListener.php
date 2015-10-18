<?php

// src/FBN/UserBundle/EventListener/FOSUserEventListener.php


namespace FBN\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Listener responsible to change the redirection when a form is successfully filled and when registration is confirmed.
 */
class RedirectListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => array('onSuccess',-10),
            FOSUserEvents::CHANGE_PASSWORD_SUCCESS => array('onSuccess',-10),
            FOSUserEvents::PROFILE_EDIT_SUCCESS => array('onSuccess',-10),
            FOSUserEvents::RESETTING_RESET_SUCCESS => array('onSuccess',-10),
            FOSUserEvents::REGISTRATION_CONFIRM => array('onSuccess',-10),
        );
    }

    public function onSuccess(Event $event)
    {
        $url = $this->router->generate('fbn_guide_accueil');

        $event->setResponse(new RedirectResponse($url));
    }
}
