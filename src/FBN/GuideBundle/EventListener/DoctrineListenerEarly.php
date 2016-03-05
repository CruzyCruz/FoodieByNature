<?php

namespace FBN\GuideBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\OnFlushEventArgs;
use FBN\GuideBundle\Slug\SlugManager;

class DoctrineListenerEarly implements EventSubscriber
{
    /**
     * @var SlugManager
     */
    private $slugManager;

    public function __construct(SlugManager $slugManager)
    {
        $this->slugManager = $slugManager;
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
     * - Update attribute slugFromCoordinatesISO of entity Restaurant on CoordinatesISO insertion|update.
     *
     * @param OnFlushEventArgs $args
     */
    public function doOnFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            $this->slugManager->updateRestaurantSlugFromCoordinatesISOOnFlush($entity, $em, $uow);
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $this->slugManager->updateRestaurantSlugFromCoordinatesISOOnFlush($entity, $em, $uow);
        }
    }
}
