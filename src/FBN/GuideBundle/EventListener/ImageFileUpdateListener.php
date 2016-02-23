<?php

namespace FBN\GuideBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vich\UploaderBundle\Event\Event;
use Vich\UploaderBundle\Event\Events;
use FBN\GuideBundle\File\ImageManager;

/**
 * Listener responsible to update an Image Entity when the related file is uploaded.
 */
class ImageFileUpdateListener implements EventSubscriberInterface
{
    /**
     * @var ImageManager
     */
    private $im;

    public function __construct(ImageManager $im)
    {
        $this->im = $im;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::POST_UPLOAD => array('updateImageEntity'),
        );
    }

    /**
     * Rename image file and update Image entity.
     *
     * @param Event $event The event.
     */
    public function updateImageEntity(Event $event)
    {
        $image = $event->getObject();

        // No flush needed as the POST_UPLOAD event is triggered during doctrine preUpdate event.
        $this->im->renameImageFile($image);
    }
}
