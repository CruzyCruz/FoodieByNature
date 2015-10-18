<?php

namespace FBN\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\EventDispatcher\Event;
use FOS\UserBundle\Model\UserInterface;
use FBN\UserBundle\FBNUserEvents;

class UserController extends Controller
{
    public function editProfileChangePasswordAction()
    {
        return $this->render('FBNUserBundle:ProfileEditChangePassword:profileeditchangepassword.html.twig');
    }

    public function deleteUserAction()
    {
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $userManager->deleteUser($user);

        $event = new Event();

        /** @var $dispatcher \Symfony\Component\EventDispatcher\Event */
        $dispatcher = $this->get('event_dispatcher');

        $dispatcher->dispatch(FBNUserEvents::PROFILE_USER_DELETED, $event);

        $url = $this->generateUrl('fbn_guide_accueil');

        return new RedirectResponse($url);
    }

    public function authenticityCSRFTokenAction()
    {
        $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticity')->getValue();

        $content = $this->renderView(
            'FBNUserBundle:CSRF:CSRFmetaTag.html.twig',
            array('csrfToken' => $csrfToken)
        );

        return new Response($content);
    }
}
