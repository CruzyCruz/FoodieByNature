<?php

namespace FBN\UserBundle\EventListener;

use FBN\UserBundle\FBNUserEvents;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\UserBundle\Model\UserInterface;

class AlreadyLoggedListener implements EventSubscriberInterface
{
    private $blockedRoutes = array(
        'fos_user_security_login',
        'fos_user_registration_register',
        'fos_user_resetting_request',
    );

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker, EventDispatcherInterface $dispatcher, UrlGeneratorInterface $router)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->dispatcher = $dispatcher;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => array('checkIfAlreadyLogged', -1000),
        );
    }

    public function checkIfAlreadyLogged(Event $event)
    {
        $securityToken = $this->tokenStorage->getToken();

        $requestType = $event->getRequestType();

        if (null == $securityToken || HttpKernelInterface::MASTER_REQUEST !== $requestType) {
            return;
        }

        $route = $event->getRequest()->get('_route');

        $user = $securityToken->getUser();

        if (is_object($user) || $user instanceof UserInterface) {
            if ($this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                if (in_array($route, $this->blockedRoutes)) {
                    $url = $this->router->generate('fbn_guide_home');
                    $event->setResponse(new RedirectResponse($url));

                    $event = new Event();
                    $this->dispatcher->dispatch(FBNUserEvents::SECURITY_ALREADY_LOGGED, $event);
                }
            }
        }
    }
}
