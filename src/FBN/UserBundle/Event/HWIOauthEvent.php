<?php

namespace FBN\UserBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class HWIOauthEvent extends Event
{    
    private $userName;
    private $resourceOwnerName;

    public function __construct($userName, $resourceOwnerName)
    {
        $this->userName = $userName;
        $this->resourceOwnerName = $resourceOwnerName;
    }

    /**
     * Get the real name of user.
     *
     * @return null|string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Get the provider name.
     *
     * @return null|string
     */
    public function getResourceOwnerName()
    {
        return $this->resourceOwnerName;
    }    
}
