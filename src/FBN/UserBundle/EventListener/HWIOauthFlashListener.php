<?php

namespace FBN\UserBundle\EventListener;

use FBN\UserBundle\FBNUserEvents;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\TranslatorInterface;

class HWIOauthFlashListener implements EventSubscriberInterface
{
    private static $successMessages = array(
        FBNUserEvents::HWIOAUTH_ADD_OAUTH_ID_SUCCESS => 'header.oauth_id_success',
    );

    private $session;
    private $translator;

    public function __construct(Session $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FBNUserEvents::HWIOAUTH_ADD_OAUTH_ID_SUCCESS => 'addSuccessFlash',
        );
    }

    public function addSuccessFlash(Event $event)
    {
        if (!isset(self::$successMessages[$event->getName()])) {
            throw new \InvalidArgumentException('This event does not correspond to a known flash message');
        }

        // Let the possibility to manage other events
        if ($event->getName() == FBNUserEvents::HWIOAUTH_ADD_OAUTH_ID_SUCCESS) {
            $params = array('%resource_owner_name%' => ucfirst($event->getResourceOwnerName()));
        }

        $this->session->getFlashBag()->add('hwi_success', $this->trans(self::$successMessages[$event->getName()], $params));
    }

    private function trans($message, array $params = array())
    {
        return $this->translator->trans($message, $params, 'HWIOAuthBundle');
    }
}
