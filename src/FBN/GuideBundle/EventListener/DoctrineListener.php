<?php

namespace FBN\GuideBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use FBN\GuideBundle\Entity\CoordinatesISO;
use FBN\GuideBundle\Entity\Restaurant;
use FBN\GuideBundle\File\ImageManager;

class DoctrineListener implements EventSubscriber
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
            'postPersist',
            'postUpdate',
            'postRemove',
        );
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->renameImageOnImagePersist($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->updateRestaurantSlugFromCoordinatesISO($args);
        $this->renameImageOnSlugUpdate($args);
        $this->renameImageOnImagePersist($args);
        $this->removeEntityRelatedCachedImage($args);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->removeEntityRelatedCachedImage($args);
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
                }

                return;
            }

            return;
        }

        return;
    }

    public function renameImageOnImagePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        $this->imageManager->renameImageOnImagePersist($entity, $em);
    }

    /**
     * Rename Image on entity related slug update.
     *
     * @param LifecycleEventArgs $args
     */
    public function renameImageOnSlugUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $em = $args->getEntityManager();

        $this->imageManager->renameImageOnSlugUpdate($entity, $em);
    }

    /**
     * Remove cached image file related to Image file on file update|removal.
     *
     * @param LifecycleEventArgs $args
     */
    public function removeEntityRelatedCachedImage(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->imageManager->removeEntityRelatedCachedImage($entity);
    }
}
