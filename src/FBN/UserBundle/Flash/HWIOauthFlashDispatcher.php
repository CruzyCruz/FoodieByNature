<?php

namespace FBN\UserBundle\Flash;

use FBN\UserBundle\Event\HWIOauthEvent;
use FBN\UserBundle\FBNUserEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class HWIOauthFlashDispatcher
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * Constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function dispatch($userName, $resourceOwnerName, $successType)
    {
        $event = new HWIOauthEvent($userName, $resourceOwnerName);

        // Let the possibility to manage other events
        if ($successType == 'add_oauth_id') {
            $this->dispatcher->dispatch(FBNUserEvents::HWIOAUTH_ADD_OAUTH_ID_SUCCESS, $event);
        }
    }
}
