<?php

namespace FBN\UserBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * This handler allows to manage actions at user deconnexion.
 */
class LogoutHandler implements LogoutHandlerInterface
{
    const FLASH_LOGOUT = 'security.flash.logout';

    private $session;
    private $translator;

    public function __construct(Session $session, TranslatorInterface $translator)
    {
        $this->session = $session;
        $this->translator = $translator;
    }

    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        $this->session->getFlashBag()->add('success', $this->trans(self::FLASH_LOGOUT));
    }

    private function trans($message, array $params = array())
    {
        return $this->translator->trans($message, $params, 'FOSUserBundle');
    }
}
