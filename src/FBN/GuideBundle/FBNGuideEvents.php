<?php

namespace FBN\GuideBundle;

/**
 * Contains all events thrown in the FBNGuideBundle.
 */
final class FBNGuideEvents
{
    /**
     * The IMAGE_UPDATE event occurs when an image file is updated (moved).
     *
     * This event allows you to access the id and class name of the related Image entity.
     * The event listener method receives a FBN\GuideBundle\Event\ImageUpdateEvent instance.
     */
    const IMAGE_UPDATE = 'fbn_guide.image_update';
}
