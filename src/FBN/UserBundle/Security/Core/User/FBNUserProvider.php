<?php

namespace FBN\UserBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use FBN\UserBundle\Flash\HWIOauthFlashDispatcher;
use FOS\UserBundle\Model\UserManagerInterface;

class FBNUserProvider extends FOSUBUserProvider
{
    /**
     * @var HWIOauthFlashDispatcher
     */
    protected $dispatcher;

    /**
     * Constructor.
     *
     * @param HWIOauthFlashDispatcher $dispatcher HWIOauth Flash Event Dispatcher
     */
    public function __construct(UserManagerInterface $userManager, array $properties, HWIOauthFlashDispatcher $dispatcher)
    {
        parent::__construct($userManager, $properties);
        $this->dispatcher = $dispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        // On oauth login (and user is not already connected), if user exists in database with email matching provider response email
        if (null !== $user = $this->userManager->findUserByEmail($response->getEmail())) {
            $property = $this->getProperty($response);
            $username = $response->getUsername();

            if (null === $username) {
                throw new AccountNotLinkedException(sprintf("User '%s' not found.", $username));
            }

            // If provider ID is null or different from the one contained in the response, provider ID is added or changed
            if (null === $this->accessor->getValue($user, $property)
                ||
                $this->accessor->getValue($user, $property) != $username) {
                // Adding his oauth provider ID to database
                $this->accessor->setValue($user, $property, $username);

                // Event to emit flash message to prevent user
                $resourceOwnerName = $response->getResourceOwner()->getName();
                $this->dispatcher->dispatch(null, $resourceOwnerName, 'add_oauth_id');

                return $user;
            }

            // If not, user is returned
            return $user;
        }

        // If not, standard bundle implementation
        return parent::loadUserByOAuthUserResponse($response);
    }
}
