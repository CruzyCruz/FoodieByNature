<?php

namespace FBN\UserBundle;

/**
 * Contains all events thrown in the FBNUserBundle.
 */
final class FBNUserEvents
{
    /**
     * The PROFILE_USER_DELETED event occurs when the user delete his account.
     *
     * This event allows you to access the name of the event.
     * The event listener method receives a Symfony\Component\EventDispatcher\Event instance.
     */
    const PROFILE_USER_DELETED = 'fbn_user.profile.deleted';

    /**
     * The SECURITY_ALREADY_LOGGED event occurs when the user try to log being already logged.
     *
     * This event allows you to access the name of the event.
     * The event listener method receives a Symfony\Component\EventDispatcher\Event instance.
     */
    const SECURITY_ALREADY_LOGGED = 'fbn_user.security.already_logged';

    /**
     * The HWIOAUTH_CONNECT_SUCCESS event occurs when the oauth account is connected to the FBN account
     * 1/ FBN account logging
     * 2/ Oauth account logging
     * This event allows you to access the name of the event name and the username (resourceOwnername is null for this event)
     * The event listener method receives a FBN\UserBundle\Event\HWIOauthEvent instance.
     */
    const HWIOAUTH_CONNECT_SUCCESS = 'fbn_user.hwioauth.connect_success';

    /**
     * The HWIOAUTH_REGISTRATION_SUCCESS event occurs when the oauth account is used to create a new user account using the hwioauth form.
     *
     * This event allows you to access the name of the event name and the username (resourceOwnername is null for this event)
     * The event listener method receives a FBN\UserBundle\Event\HWIOauthEvent instance.
     */
    const HWIOAUTH_REGISTRATION_SUCCESS = 'fbn_user.hwioauth.registration_success';

    /**
     * The HWIOAUTH_ADD_OAUTH_ID_SUCCESS event occurs when the oauth account is used to create a new user account using the hwioauth form.
     *
     * This event allows you to access the name of the event and the resource owner name
     * The event listener method receives a FBN\UserBundle\Event\HWIOauthEvent instance.
     */
    const HWIOAUTH_ADD_OAUTH_ID_SUCCESS = 'fbn_user.hwioauth.add_oauth_id_success';
}
