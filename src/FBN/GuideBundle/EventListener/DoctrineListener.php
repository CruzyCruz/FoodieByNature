<?php

namespace FBN\GuideBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use FBN\GuideBundle\Entity\CoordinatesISO;
use FBN\GuideBundle\Entity\Restaurant;

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
        $this->updateRestaurantImageName($args);
    }

    /**
     * Update attribute slugFromCoordinatesISO of entity Restaurant on attribute slug CoordinatesISO entity postUpdate.
     *
     * @param LifecycleEventArgs $args
     */
    public function updateRestaurantSlugFromCoordinatesISO(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof CoordinatesISO) {
            $coordinates = $entity->getCoordinates();

            if (null !== $coordinates) {
                $restaurant = $coordinates->getRestaurant();

                if (null !== $restaurant) {
                    $em = $args->getEntityManager();
                    $restaurant->setSlugFromCoordinatesISO($entity->getSlug());
                    $em->flush();
                } else {
                    return;
                }
            } else {
                return;
            }
        }

        return;
    }

    /**
     * Update ****.
     *
     * @param LifecycleEventArgs $args
     */
    public function updateRestaurantImageName(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Restaurant) {
            $image = $entity->getImage();

            if (null !== $image) {
                $file = $image->getFile();
                if (null !== $file) {
                    $em = $args->getEntityManager();

                    $fileDirectory = $file->getPath();
                    $name = $image->getName();
                    $extension = $file->getExtension();

                    $updatedName = $entity->getSlug().'.'.$extension;
                    $file->move($fileDirectory, $updatedName);
                    $image->setName($updatedName);
                    $image->setUpdatedAt(new \DateTime());

                    $em->flush();
                } else {
                    return;
                }
            } else {
                return;
            }
        }

        return;
    }
}
