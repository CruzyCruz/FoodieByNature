<?php

namespace FBN\GuideBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\UnitOfWork;
use FBN\GuideBundle\Entity\Coordinates;
use FBN\GuideBundle\Entity\CoordinatesISO;
use FBN\GuideBundle\Entity\Event;
use FBN\GuideBundle\Manager\CoordinatesManager;
use FBN\GuideBundle\Manager\EventManager;

class SlugManager
{
    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var CoordinatesManager
     */
    private $coordinatesManager;

    public function __construct(EventManager $eventManager, CoordinatesManager $coordinatesManager)
    {
        $this->eventManager = $eventManager;
        $this->coordinatesManager = $coordinatesManager;
    }

    /**
     * Update attribute slugFromCoordinatesISO of entity Restaurant, Shop, WinemakerDomain, Event on CoordinatesISO insertion|update (onFlush event).
     *
     * @param object $entity the entity
     * @param object $em     the entity manager
     * @param object $uow    the unit of work
     */
    public function updateRstrShpWnmkrDmnEvtSlugFromCoordinatesISOOnFlush($entity, ObjectManager $em, UnitOfWork $uow)
    {
        if ($entity instanceof CoordinatesISO) {
            $coordinates = $entity->getCoordinates();

            if (null !== $coordinates) {
                $codeISO = $coordinates->getCoordinatesCountry()->getCodeISO();
                $coordinatesRelatedEntity = $this->coordinatesManager->findEntityLinkedToCoordinates($coordinates);

                if (null !== $coordinatesRelatedEntity) {
                    // If the city has changed
                    if (array_key_exists('coordinates'.$codeISO.'City', $uow->getEntityChangeSet($entity))) {
                        $city = $uow->getEntityChangeSet($entity)['coordinates'.$codeISO.'City'][1]->getCity();
                        $slugFromCoordinatesISO = $this->getSlugFromCoordinatesISO($city, $coordinates);
                        $coordinatesRelatedEntity->setSlugFromCoordinatesISO($slugFromCoordinatesISO);

                        $classMetadata = $em->getClassMetadata(get_class($coordinatesRelatedEntity));
                        $uow->recomputeSingleEntityChangeSet($classMetadata, $coordinatesRelatedEntity);

                        if ($coordinatesRelatedEntity instanceof Event) {
                            $events = $coordinatesRelatedEntity->getEvent();
                            if (!(empty($events))) {
                                foreach ($events as $event) {
                                    $event->setSlugFromCoordinatesISO($slugFromCoordinatesISO);

                                    $classMetadata = $em->getClassMetadata(get_class($event));
                                    $uow->recomputeSingleEntityChangeSet($classMetadata, $event);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Update attribute slugFromCoordinatesISO of Event entity with null coordinates (alternative location) on insertion|update (on Flush event).
     *
     * @param object $entity the entity
     * @param object $em     the entity manager
     * @param object $uow    the unit of work
     */
    public function updateEvtWithExternalLocationSlugFromCoordinatesISOOnFlush($entity, ObjectManager $em, UnitOfWork $uow)
    {
        if ($entity instanceof Event) {
            if (null === $entity->getCoordinates()) {
                $eventExternalLocation = $this->eventManager->findEventExternalLocation($entity);
                $slugFromCoordinatesISO = $this->getSlugFromCoordinatesISO(null, $eventExternalLocation->getCoordinates());
                $entity->setSlugFromCoordinatesISO($slugFromCoordinatesISO);

                $classMetadata = $em->getClassMetadata(get_class($entity));
                $uow->recomputeSingleEntityChangeSet($classMetadata, $entity);
            }
        }
    }

    /**
     * Build and return slugFromCoordinatesISO string from Coordinates.
     *
     * @param null | string $city
     * @param Coordinates   $coordinates
     *
     * @return string
     */
    public function getSlugFromCoordinatesISO($city, Coordinates $coordinates)
    {
        $codeISO = $coordinates->getCoordinatesCountry()->getCodeISO();
        $getCoordinatesISO = 'getCoordinates'.$codeISO;
        $getCoordinatesISOCity = 'getCoordinates'.$codeISO.'City';
        $city = ($city !== null) ? $city : $coordinates->$getCoordinatesISO()->$getCoordinatesISOCity()->getCity();
        $country = $coordinates->getCoordinatesCountry()->getCountry();

        return  $country.'-'.$city;
    }
}
