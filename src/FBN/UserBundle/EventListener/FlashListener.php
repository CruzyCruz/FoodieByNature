<?php

namespace FBN\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FBN\UserBundle\FBNUserEvents;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class FlashListener implements EventSubscriberInterface
{
    private static $successMessages = array(
        FOSUserEvents::REGISTRATION_CONFIRM => 'registration.flash.confirm',
        SecurityEvents::INTERACTIVE_LOGIN => 'security.flash.login',
        FBNUserEvents::PROFILE_USER_DELETED => 'profile.flash.deleted',
        FBNUserEvents::SECURITY_ALREADY_LOGGED => 'security.flash.already_logged',
    );

    private $session;
    private $translator;
    private $tokenStorage;

    public function __construct(Session $session, TranslatorInterface $translator, TokenStorageInterface $tokenStorage)
    {
        $this->session = $session;
        $this->translator = $translator;
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_CONFIRM => 'addSuccessFlash',
            SecurityEvents::INTERACTIVE_LOGIN => 'addSuccessFlash',
            FBNUserEvents::PROFILE_USER_DELETED => 'addSuccessFlash',
            FBNUserEvents::SECURITY_ALREADY_LOGGED => 'addSuccessFlash',
        );
    }

    public function addSuccessFlash(Event $event)
    {
        if (!isset(self::$successMessages[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message');
        }

        $params = array();

        $user = $this->getUser($event);

        if (is_object($user) || $user instanceof UserInterface) {
            $params = array('%username%' => $user->getUsername());
        }

        $this->session->getFlashBag()->add('success', $this->trans(self::$successMessages[$event->getName()], $params));
    }

    private function getUser($event)
    {
        if ($event->getName() == FOSUserEvents::REGISTRATION_CONFIRM) {
            return $event->getUser();
        }

        return $this->tokenStorage->getToken()->getUser();
    }

    private function trans($message, array $params = array())
    {
        return $this->translator->trans($message, $params, 'FOSUserBundle');
    }
}
