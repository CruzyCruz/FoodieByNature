<?php

namespace FBN\GuideBundle\File;

class ImageManager
{
    /**
     * List of entities linked to an image.
     *
     * @var array
     */
    private static $entitiesLinkedToImage = array(
        'FBN\GuideBundle\Entity\Restaurant',
        'FBN\GuideBundle\Entity\Winemaker',
        'FBN\GuideBundle\Entity\Event',
        'FBN\GuideBundle\Entity\Turorial',
        'FBN\GuideBundle\Entity\TutorialChapterPara',
    );

    /**
     * Rename Image on entity related slug update.
     *
     * @param string $entity The entity.
     */
    public function renameImageOnSlugUpdate($entity, $em)
    {
        if ($this->hasImage($entity)) {
            $image = $entity->getImage();

            if (null !== $image) {
                $file = $image->getFile();
                if (null !== $file) {
                    $fileDirectory = $file->getPath();
                    $name = $image->getName();
                    $extension = $file->getExtension();

                    $updatedName = $entity->getSlug().'.'.$extension;
                    $file->move($fileDirectory, $updatedName);
                    $image->setName($updatedName);
                    $image->setUpdatedAt(new \DateTime());

                    $em->flush();
                }

                return;
            }

            return;
        }

        return;
    }

    /**
     * Check if an entity is linked to an image.
     *
     * @param string $entity The entity.
     *
     * @return bool
     */
    private function hasImage($entity)
    {
        foreach (self::$entitiesLinkedToImage as $entityLinkedToImage) {
            if ($entity instanceof $entityLinkedToImage) {
                return true;
            }
        }

        return false;
    }
}
