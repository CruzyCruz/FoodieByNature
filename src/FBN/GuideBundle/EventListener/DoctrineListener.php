<?php

namespace FBN\GuideBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use FBN\GuideBundle\Entity\CoordinatesISO;

class DoctrineListener implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            'postUpdate',
        );
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->updateRestaurantSlugFromCoordinatesISO($args);
    }

    public function updateRestaurantSlugFromCoordinatesISO(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof CoordinatesISO) {
            $restaurant = $entity->getCoordinates()->getRestaurant();
            if (null !== $restaurant) {
                $em = $args->getEntityManager();
                $restaurant->setSlugFromCoordinatesISO($entity->getSlug());
                $em->flush();
            } else {
                return;
            }
        }

        return;
    }
}
