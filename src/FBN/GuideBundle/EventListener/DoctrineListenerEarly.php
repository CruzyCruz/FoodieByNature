<?php

namespace FBN\GuideBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\OnFlushEventArgs;
use FBN\GuideBundle\Slug\SlugManager;
use FBN\GuideBundle\Coordinates\CoordinatesManager;
use FBN\GuideBundle\Event\EventManager;

class DoctrineListenerEarly implements EventSubscriber
{
    /**
     * @var SlugManager
     */
    private $slugManager;

    /**
     * @var CoordinatesManager
     */
    private $coordinatesManager;

    /**
     * @var EventManager
     */
    private $eventManager;

    public function __construct(SlugManager $slugManager, CoordinatesManager $coordinatesManager, EventManager $eventManager)
    {
        $this->slugManager = $slugManager;
        $this->coordinatesManager = $coordinatesManager;
        $this->eventManager = $eventManager;
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
     * - Update attribute slugFromCoordinatesISO of entity Restaurant, Shop, WinemakerDomain, Event on CoordinatesISO insertion|update.
     * - Update attribute slugFromCoordinatesISO of Event entity with null coordinates (alternative location) on insertion|update (on Flush event).
     * - Set|Update attributes lat/long on CoordinatesISO insertion|update.
     * - Manage events (modification or removal) entities on related entities removal.
     *
     * @param OnFlushEventArgs $args
     */
    public function doOnFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            $this->slugManager->updateRstrShpWnmkrDmnEvtSlugFromCoordinatesISOOnFlush($entity, $em, $uow);
            $this->slugManager->updateEvtWithExternalLocationSlugFromCoordinatesISOOnFlush($entity, $em, $uow);
            $this->coordinatesManager->setLatLongCoordinatesISOOnFlush($entity, $em, $uow);
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $this->slugManager->updateRstrShpWnmkrDmnEvtSlugFromCoordinatesISOOnFlush($entity, $em, $uow);
            $this->slugManager->updateEvtWithExternalLocationSlugFromCoordinatesISOOnFlush($entity, $em, $uow);
            $this->coordinatesManager->setLatLongCoordinatesISOOnFlush($entity, $em, $uow);
        }

        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            $this->eventManager->manageEvents($entity, $em, $uow);
        }
    }
}
