<?php

namespace FBN\GuideBundle\Event;

use FBN\GuideBundle\Coordinates\CoordinatesManager;
use Symfony\Component\PropertyAccess\PropertyAccess;
use FBN\GuideBundle\Entity\Restaurant;
use FBN\GuideBundle\Entity\Shop;
use FBN\GuideBundle\Entity\WinemakerDomain;
use FBN\GuideBundle\Entity\Event;

class EventManager
{
    /**
     * @var CoordinatesManager
     */
    private $coordinatesManager;

    /**
     * @var PropertyAccessor
     */
    protected $accessor;

    public function __construct(CoordinatesManager $coordinatesManager)
    {
        $this->coordinatesManager = $coordinatesManager;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Manage events (modification or removal) entities on related entities removal.
     *
     * @param object $entity The entity.
     * @param object $em     The entity manager.
     * @param object $uow    The unit of work.
     */
    public function manageEvents($entity, $em, $uow)
    {
        if (($entity instanceof Restaurant) || ($entity instanceof Shop) || ($entity instanceof WinemakerDomain)) {
            $this->setEventFormerLocationCoordinatesOnRelatedEntityRemoval($entity, $em, $uow);
        }

        if ($entity instanceof Event) {
            $this->removeEventsOnRelatedEventRemoval($entity, $em);
        }

        return;
    }

    /**
     * Copy location informations (name and coordinates) in Event entity on Entity related removal (Restaurant, Shop, Winemaker).
     *
     * @param object $entity The entity.
     * @param object $em     The entity manager.
     * @param object $uow    The unit of work.
     */
    private function setEventFormerLocationCoordinatesOnRelatedEntityRemoval($entity, $em, $uow)
    {
        $events = $entity->getEvent();
        if (!(empty($events))) {
            $entityClassName = (new \ReflectionClass($entity))->getShortName();

            foreach ($events as $event) {
                $coordinates = $entity->getCoordinates();
                $codeISO = $coordinates->getCoordinatesCountry()->getCodeISO();
                $coordinatesISO = $this->accessor->getValue($coordinates, 'coordinates'.$codeISO);
                $this->accessor->setValue($event, 'formerLocationCoordinates', $this->coordinatesManager->buildViewAddress($coordinatesISO));
                $this->accessor->setValue($event, 'formerLocationName', $entity->__toString());
                $this->accessor->setValue($event, 'formerLocation', $entityClassName);
                $this->accessor->setValue($event, 'useExtTel', false);
                $this->accessor->setValue($event, 'useExtSite', false);

                $classMetadata = $em->getClassMetadata(get_class($event));
                $uow->recomputeSingleEntityChangeSet($classMetadata, $event);
            }
        } else {
            $em->remove($entity->getCoordinates());
        }

        return;
    }

    /**
     * Remove all Event entities related to a main Event entity (Events * to 1 Event).
     *
     * @param object $entity The entity.
     * @param object $em     The entity manager.
     */
    private function removeEventsOnRelatedEventRemoval($entity, $em)
    {
        $events = $entity->getEvent();
        if (!(empty($events))) {
            foreach ($events as $event) {
                $em->remove($event);
            }
        }

        return;
    }
}
