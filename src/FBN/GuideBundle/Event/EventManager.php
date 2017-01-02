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
     * @param object $entity the entity
     * @param object $em     the entity manager
     * @param object $uow    the unit of work
     */
    public function setEventFormerLocationCoordinatesOnRelatedEntityRemoval($entity, $em, $uow)
    {
        if (($entity instanceof Restaurant) || ($entity instanceof Shop) || ($entity instanceof WinemakerDomain)) {
            $events = $entity->getEvent();

            if (!(empty($events))) {
                $formerLocationName = ($entity instanceof WinemakerDomain) ? $entity->getWinemaker()->getName() : $entity->getName();
                $entityClassName = (new \ReflectionClass($entity))->getShortName();

                $coordinates = $entity->getCoordinates();
                $codeISO = $coordinates->getCoordinatesCountry()->getCodeISO();
                $coordinatesISO = $this->accessor->getValue($coordinates, 'coordinates'.$codeISO);

                foreach ($events as $event) {
                    $this->accessor->setValue($event, 'formerLocationCoordinates', $this->coordinatesManager->buildViewAddress($coordinatesISO));
                    $this->accessor->setValue($event, 'formerLocationName', $formerLocationName);
                    $this->accessor->setValue($event, 'formerLocation', $entityClassName);
                    $this->accessor->setValue($event, 'useExtTel', false);
                    $this->accessor->setValue($event, 'useExtSite', false);

                    $classMetadata = $em->getClassMetadata(get_class($event));
                    $uow->recomputeSingleEntityChangeSet($classMetadata, $event);
                }
            }
        }
    }

    /**
     * Return event related entity (alternative location when coordinates are null).
     *
     * @param Event $event the event object
     *
     * @return object $eventExternalLocation the related entity
     */
    public function findEventExternalLocation(Event $event)
    {
        ($eventExternalLocation = $event->getRestaurant())
        || ($eventExternalLocation = $event->getShop())
        || ($eventExternalLocation = $event->getWinemakerDomain())
        || ($eventExternalLocation = $event->getEventPast());

        return $eventExternalLocation;
    }
}
