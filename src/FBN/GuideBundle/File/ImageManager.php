<?php

namespace FBN\GuideBundle\File;

use Symfony\Component\HttpFoundation\File\File;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Storage\FileSystemStorage;

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

    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var FileSystemStorage
     */
    private $fileSystemStorage;

    public function __construct(CacheManager $cacheManager, $pathImagesRestaurant, $pathImagesWinemaker, $pathImagesEvent, $pathImagesTutorial, FileSystemStorage $fileSystemStorage)
    {
        $this->cacheManager = $cacheManager;
        $this->filePathEntitiesCorrespondance['ImageRestaurant'] = $pathImagesRestaurant;
        $this->filePathEntitiesCorrespondance['ImageWinemaker'] = $pathImagesWinemaker;
        $this->filePathEntitiesCorrespondance['ImageEvent'] = $pathImagesEvent;
        $this->filePathEntitiesCorrespondance['ImageTutorial'] = $pathImagesTutorial;
        $this->filePathEntitiesCorrespondance['ImageTutorialChapterPara'] = $pathImagesTutorial;
        $this->fileSystemStorage = $fileSystemStorage;
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

            if ((null !== $image) && (null !== $image->getName())) {
                $this->renameImageFromSlug($image, $em);
            }

            return;
        }

        return;
    }

    public function renameImageOnImagePersist($entity, $em)
    {
        $classInfo = new \ReflectionClass($entity);

        if ($classInfo->isSubclassOf('FBN\GuideBundle\Entity\Image')) {
            $this->renameImageFromSlug($entity, $em);
        }
    }

    private function renameImageFromSlug($image, $em)
    {
        $pathToFile = $this->fileSystemStorage->resolvePath($image, 'file');
        $file = new File($pathToFile);

        if (null !== $file) {
            $fileDirectory = $file->getPath();
            $name = $image->getName();
            $extension = $file->getExtension();
            $actualSlug = str_replace('.'.$extension, '', $name);

            if ($actualSlug != $image->getSlugFromRelatedEntity()) {
                if (file_exists($fileDirectory.'/'.$name)) {
                    $updatedName = $image->getSlugFromRelatedEntity().'.'.$extension;
                    $file->move($fileDirectory, $updatedName);
                    $image->setName($updatedName);
                    $image->setUpdatedAt(new \DateTime());

                    $em->flush();
                }
            }
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
