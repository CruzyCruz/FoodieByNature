<?php

namespace FBN\GuideBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\OnFlushEventArgs;
use FBN\GuideBundle\File\ImageManager;

class DoctrineListenerLate implements EventSubscriber
{
    /**
     * @var ImageManager
     */
    private $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::onFlush,
        );
    }

    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $this->doOnFlush($eventArgs);
    }

    /**
     * On flush do the following.
     *
     * - Rename Image file from related Entity (Article).
     *
     * @param OnFlushEventArgs $args
     */
    public function doOnFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            $this->imageManager->renameImageFileFromArticleOnFlush($entity, $em, $uow);
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $this->imageManager->renameImageFileFromArticleOnFlush($entity, $em, $uow);
        }
    }
}
