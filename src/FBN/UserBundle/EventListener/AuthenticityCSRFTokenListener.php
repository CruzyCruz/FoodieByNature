<?php

namespace FBN\UserBundle\EventListener;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class AuthenticityCSRFTokenListener implements EventSubscriberInterface
{
    /**
     * @var CsrfTokenManagerInterface
     */
    private $csrfTokenManager;

    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array('checkAuthenticityCSRFToken',-500),
        );
    }

    public function checkAuthenticityCSRFToken(Event $event)
    {
        $request = $event->getRequest();

        if ($request->isXmlHttpRequest() && !$request->isMethodSafe()) {

            $csrfToken = $request->headers->get('x-csrf-token');

            if (!$this->csrfTokenManager->isTokenValid(new CsrfToken('authenticity', $csrfToken))) {                
                // 403 : Forbidden                           
                $event->setResponse(new JsonResponse('',403));
            }

            return;         
        }

        return;
    }      
}
