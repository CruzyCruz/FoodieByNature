<?php

namespace FBN\GuideBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class ImageUpdateEvent extends Event
{
    private $id;
    private $imageClass;
    private $updatedName;

    public function __construct($id, $imageClass, $updatedName)
    {
        $this->id = $id;
        $this->imageClass = $imageClass;
        $this->updatedName = $updatedName;
    }

    /**
     * Get the id of Image entity.
     *
     * @return int
     */
    public function getId()
    {
        return $this->userName;
    }

    /**
     * Get the Image entity class.
     *
     * @return nstring
     */
    public function getImageClass()
    {
        return $this->imageClass;
    }

    /**
     * Get the udpated image file name.
     *
     * @return string
     */
    public function getUpdatedName()
    {
        return $this->updatedName;
    }
}
