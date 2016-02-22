<?php

namespace FBN\GuideBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vich\UploaderBundle\Event\Events;
use FBN\GuideBundle\File\ImageManager;

//use FBN\GuideBundle\FBNGuideEvents;

/**
 * Listener responsible to update an Image Entity when the related file is updated (moved).
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

    public function updateImageEntity(Event $event)
    {
        $image = $event->getObject();

        // No flush needed as the POST_UPLOAD event is triggered during doctrine preUpdate event.
        $this->im->renameImageFile($image);
    }
}
