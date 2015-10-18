<?php

namespace FBN\UserBundle\EventListener;

use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
 
/**
 * When the user is not authenticated at all (i.e. when the security context has no token yet), 
 * the firewall's entry point will be called to start() the authentication process. 
 */

class LoginEntryPoint implements AuthenticationEntryPointInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    protected $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * This method receives the current Request object and the exception by which the exception 
     * listener was triggered. 
     * 
     * The method should return a Response object
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        if ($request->isXmlHttpRequest()) {  

            return new JsonResponse('',401);

        }

        return new RedirectResponse($this->router->generate('fos_user_security_login'));
    }
}