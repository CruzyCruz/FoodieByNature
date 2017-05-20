<?php

namespace FBN\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\EventDispatcher\Event;
use FOS\UserBundle\Model\UserInterface;
use FBN\UserBundle\FBNUserEvents;

class UserController extends Controller
{
    /**
     * Edit user, change user password or delete user.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editProfileChangePasswordAction(Request $request)
    {
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid()) {
            /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');
            $userManager->deleteUser($user);

            $event = new Event();
            /** @var $dispatcher Symfony\Component\EventDispatcher\EventDispatcherInterface */
            $dispatcher = $this->get('event_dispatcher');
            $dispatcher->dispatch(FBNUserEvents::PROFILE_USER_DELETED, $event);

            $url = $this->generateUrl('fbn_guide_home');

            return new RedirectResponse($url);
        }

        return $this->render('FBNUserBundle:ProfileEditChangePassword:profileeditchangepassword.html.twig', array(
            'form' => $form->createView(),
        ));
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
