<?php

namespace FBN\GuideBundle\Slug;

use FBN\GuideBundle\Entity\CoordinatesISO;

class SlugManager
{
    /**
     * Update attribute slugFromCoordinatesISO of entity Restaurant and Shop on CoordinatesISO insertion|update (onFlush event).
     *
     * @param object $entity The entity.
     * @param object $em     The entity manager.
     * @param object $uow    The unit of work.
     */
    public function updateRestaurantShopSlugFromCoordinatesISOOnFlush($entity, $em, $uow)
    {
        if ($entity instanceof CoordinatesISO) {
            $coordinates = $entity->getCoordinates();

            if (null !== $coordinates) {
                $codeISO = $coordinates->getCoordinatesCountry()->getCodeISO();
                $articles[] = $coordinates->getRestaurant();
                $articles[] = $coordinates->getShop();

                foreach ($articles as $article) {
                    if (null !== $article) {
                        $article->setSlugFromCoordinatesISO($uow->getEntityChangeSet($entity)['coordinates'.$codeISO.'City'][1]->getCity());

                        $classMetadata = $em->getClassMetadata(get_class($article));
                        $uow->recomputeSingleEntityChangeSet($classMetadata, $article);
                    }
                }

                return;
            }

            return;
        }

        return;
    }
}
