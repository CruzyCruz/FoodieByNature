<?php

namespace FBN\GuideBundle\Slug;

use FBN\GuideBundle\Entity\CoordinatesISO;
use FBN\GuideBundle\Entity\Restaurant;

class SlugManager
{
    /**
     * Update attribute slugFromCoordinatesISO of entity Restaurant from attribute slug of entity CoordinatesISO onFlush event.
     *
     * @param object $entity The entity.
     * @param object $em     The entity manager.
     * @param object $uow    The unit of work.
     */
    public function updateRestaurantSlugFromCoordinatesISOOnFlush($entity, $em, $uow)
    {
        if ($entity instanceof CoordinatesISO) {
            $coordinates = $entity->getCoordinates();

            if (null !== $coordinates) {
                $restaurant = $coordinates->getRestaurant();

                if (null !== $restaurant) {
                    $restaurant->setSlugFromCoordinatesISO($uow->getEntityChangeSet($entity)['city'][1]);

                    $classMetadata = $em->getClassMetadata(get_class($restaurant));
                    $uow->recomputeSingleEntityChangeSet($classMetadata, $restaurant);
                }

                return;
            }

            return;
        }

        return;
    }
}
