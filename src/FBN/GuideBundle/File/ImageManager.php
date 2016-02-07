<?php

namespace FBN\GuideBundle\File;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;
//use FBN\GuideBundle\Entity\Restaurant;
use FBN\GuideBundle\Entity\ImageRestaurant;

class ImageManager
{
    private $pathImagesRestaurant;
    private $pathImagesWinemaker;
    private $pathImagesEvent;
    private $pathImagesTutorial;

    /**
     * List of entities linked to an image.
     *
     * @var array
     */
    private static $entitiesLinkedToImage = array(
        'FBN\\GuideBundle\\Entity\\Restaurant',
        'FBN\\GuideBundle\\Entity\\Winemaker',
        'FBN\\GuideBundle\\Entity\\Event',
        'FBN\\GuideBundle\\Entity\\Tutorial',
        'FBN\\GuideBundle\\Entity\\TutorialChapterPara',
    );

    /**
     * Correspondance between Image class and image file path (relative to /web directory).
     *
     * @var array
     */
    private $filePathEntitiesCorrespondance = array();

    //private $pathTest;

    /**
     * @var CacheManager
     */
    private $cacheManager;

    public function __construct(CacheManager $cacheManager, $pathImagesRestaurant, $pathImagesWinemaker, $pathImagesEvent, $pathImagesTutorial)
    {
        $this->cacheManager = $cacheManager;
        $this->filePathEntitiesCorrespondance['ImageRestaurant'] = $pathImagesRestaurant;
        $this->filePathEntitiesCorrespondance['ImageWinemaker'] = $pathImagesWinemaker;
        $this->filePathEntitiesCorrespondance['ImageEvent'] = $pathImagesEvent;
        $this->filePathEntitiesCorrespondance['ImageTutorial'] = $pathImagesTutorial;
        $this->filePathEntitiesCorrespondance['ImageTutorialChapterPara'] = $pathImagesTutorial;
        //$this->pathTest = $pathImagesRestaurant;
    }

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
                    $actualSlug = str_replace('.'.$extension, '', $name);

                    if ($actualSlug != $entity->getSlug()) {
                        if (file_exists($fileDirectory.'/'.$name)) {
                            $updatedName = $entity->getSlug().'.'.$extension;
                            $file->move($fileDirectory, $updatedName);
                            $image->setName($updatedName);
                            $image->setUpdatedAt(new \DateTime());

                            $em->flush();
                        }
                    }
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

    /**
     * Remove cached image file related to Image file on update|removal.
     *
     * @param string $entity The entity.
     */
    public function removeEntityRelatedCachedImage($entity)
    {
        $classInfo = new \ReflectionClass($entity);

        if ($classInfo->isSubclassOf('FBN\GuideBundle\Entity\Image')) {
            $savedName = $entity->getSavedName();
            $name = $entity->getName();

            // If image file has changed.
            if (null !== $savedName) {
                $path = $this->filePathEntitiesCorrespondance[$classInfo->getShortName()];
                $this->cacheManager->remove($path.'/'.$savedName);
            }

            return;
        }

        return;
    }
}
