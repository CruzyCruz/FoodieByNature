<?php

namespace FBN\GuideBundle\File;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
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

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    public function __construct(CacheManager $cacheManager, $pathImagesRestaurant, $pathImagesWinemaker, $pathImagesEvent, $pathImagesTutorial, FileSystemStorage $fileSystemStorage, EventDispatcherInterface $dispatcher)
    {
        $this->cacheManager = $cacheManager;
        $this->filePathEntitiesCorrespondance['ImageRestaurant'] = $pathImagesRestaurant;
        $this->filePathEntitiesCorrespondance['ImageWinemaker'] = $pathImagesWinemaker;
        $this->filePathEntitiesCorrespondance['ImageEvent'] = $pathImagesEvent;
        $this->filePathEntitiesCorrespondance['ImageTutorial'] = $pathImagesTutorial;
        $this->filePathEntitiesCorrespondance['ImageTutorialChapterPara'] = $pathImagesTutorial;
        $this->fileSystemStorage = $fileSystemStorage;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Rename Image file on Entity related slug persist|update or on Image persist|update.
     */
    public function renameImageFile($entity, $em, $uow)
    {
        if ($this->hasImage($entity)) {
            $image = $entity->getImage();

            if ((null !== $image)) {
                $this->renameImageFileFromSlug($image);

                $classMetadata = $em->getClassMetadata(get_class($image));
                $uow->recomputeSingleEntityChangeSet($classMetadata, $image);
            }

            return;
        }

        return;
    }

    /**
     * Rename Image file based on entity related slug.
     */
    public function renameImageFileFromSlug($image)
    {
        $absolutePathToActualFile = $this->fileSystemStorage->resolvePath($image, 'file');

        if (file_exists($absolutePathToActualFile)) {
            $file = new File($absolutePathToActualFile);
            $fileDirectory = $file->getPath();

            $actualName = $image->getName();
            $extension = $file->getExtension();

            $actualRootName = str_replace('.'.$extension, '', $actualName);

            // If it's needed to rename Image file.
            if (null !== $image->getSlugFromRelatedEntity() && $actualRootName != $image->getSlugFromRelatedEntity()) {
                $updatedName = $image->getSlugFromRelatedEntity().'.'.$extension;

                $file->move($fileDirectory, $updatedName);

                $image->setName($updatedName);
                $image->setUpdatedAt(new \DateTime());
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
