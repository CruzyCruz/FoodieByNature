<?php

namespace FBN\GuideBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
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
            Events::onFlush,
            Events::postUpdate,
            Events::postRemove,
        );
    }

    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $this->renameImageFileFromArticleOnFlush($eventArgs);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->updateRestaurantSlugFromCoordinatesISO($args);
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

    /**
     * Rename Image file on Entity (Article) related onFlush event.
     *
     * @param OnFlushEventArgs $args
     */
    public function renameImageFileFromArticleOnFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            $this->imageManager->renameImageFileFromArticleOnFlush($entity, $em, $uow);
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $this->imageManager->renameImageFileFromArticleOnFlush($entity, $em, $uow);
        }
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
