<?php

namespace FBN\GuideBundle\EventListener;

use FBN\GuideBundle\Manager\ImageManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vich\UploaderBundle\Event\Event;
use Vich\UploaderBundle\Event\Events;

/**
 * Listener responsible to update an Image Entity when the related file is uploaded and to remove related cached file.
 */
class VichListener implements EventSubscriberInterface
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
            Events::PRE_REMOVE => array('setRelativePathToActualFile'),
            Events::POST_REMOVE => array('removeEntityRelatedCachedFile'),
            Events::POST_UPLOAD => array('renameImageFile'),
        );
    }

    /**
     * Get the relative path to actual file and set the related Image attribute from Image Manager.
     *
     * @param Event $event the event
     */
    public function setRelativePathToActualFile(Event $event)
    {
        $image = $event->getObject();
        $this->im->setRelativePathToActualFile($image);
    }

    /**
     * Remove cached image file related to Image file on update|removal from Image Manager.
     *
     * @param Event $event the event
     */
    public function removeEntityRelatedCachedFile(Event $event)
    {
        $image = $event->getObject();
        $this->im->removeEntityRelatedCachedFile($image);
    }

    /**
     * Rename image file and update Image entity from Image Manager.
     *
     * @param Event $event the event
     */
    public function renameImageFile(Event $event)
    {
        $image = $event->getObject();

        // No flush needed in im->renameImageFile() as the POST_UPLOAD event is triggered during doctrine preUpdate event.
        $this->im->renameImageFile($image);
    }
}
