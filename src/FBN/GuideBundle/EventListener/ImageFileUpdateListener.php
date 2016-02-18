<?php

namespace FBN\GuideBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;
use FBN\GuideBundle\FBNGuideEvents;

/**
 * Listener responsible to update an Image Entity when the related file is updated (moved).
 */
class ImageFileUpdateListener implements EventSubscriberInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FBNGuideEvents::IMAGE_UPDATE => array('updateImageEntity'),
        );
    }

    public function updateImageEntity(Event $event)
    {
        $image = $this->em->getRepository($event->getClass())->find($event->getId());
        $image->setName($event->getUpdatedName());
        $image->setUpdatedAt(new \DateTime());

        $this->em->flush();
    }
}
