<?php

namespace FBN\GuideBundle\File;

use Symfony\Component\HttpFoundation\File\File;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Storage\StorageInterface;

class ImageManager
{
    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var StorageInterface
     */
    private $fileSystemStorage;

    public function __construct(CacheManager $cacheManager, StorageInterface $fileSystemStorage)
    {
        $this->cacheManager = $cacheManager;
        $this->fileSystemStorage = $fileSystemStorage;
    }

    /**
     * Rename Image file from related Entity (Article) onFlush event.
     *
     * @param object $entity The entity.
     * @param object $em     The entity manager.
     * @param object $uow    The unit of work.
     */
    public function renameImageFileFromArticleOnFlush($entity, $em, $uow)
    {
        if (property_exists($entity, 'image')) {
            $image = $entity->getImage();

            if ((null !== $image)) {
                $this->renameImageFile($image);

                $classMetadata = $em->getClassMetadata(get_class($image));
                $uow->recomputeSingleEntityChangeSet($classMetadata, $image);
            }

            return;
        }

        return;
    }

    /**
     * Rename Image file.
     *
     * @param object $image The image entity.
     */
    public function renameImageFile($image)
    {
        $absolutePathToActualFile = $this->fileSystemStorage->resolvePath($image, 'file');

        if (file_exists($absolutePathToActualFile)) {
            $file = new File($absolutePathToActualFile);
            $fileDirectory = $file->getPath();

            $actualName = $image->getName();
            $extension = $file->getExtension();

            $actualRootName = str_replace('.'.$extension, '', $actualName);
            $updatedRootName = $image->buildImageRootName();

            // If it's needed to rename Image file.
            if (null !== $updatedRootName && $actualRootName != $updatedRootName) {
                $this->setRelativePathToActualFile($image);
                $updatedName = $updatedRootName.'.'.strtolower($extension);

                $file->move($fileDirectory, $updatedName);

                $this->removeEntityRelatedCachedFile($image);

                $image->setName($updatedName);
                $image->setUpdatedAt(new \DateTime());
            }

            return;
        }

        return;
    }

    /**
     * Get the relative path to actual file and set the related Image attribute.
     *
     * @param object $image The image entity.
     */
    public function setRelativePathToActualFile($image)
    {
        if (null !== $image->getName()) {
            $relativePathToActualFile = $this->fileSystemStorage->resolveUri($image, 'file');
            $image->setRelativePathToActualFile($relativePathToActualFile);
        }

        return;
    }

    /**
     * Remove cached image file related to Image file on update|removal.
     *
     * @param object $image The entity.
     */
    public function removeEntityRelatedCachedFile($image)
    {
        $relativePathToActualFile = $image->getRelativePathToActualFile();

        if (null !== $relativePathToActualFile) {
            $this->cacheManager->remove($relativePathToActualFile);
        }

        return;
    }
}
