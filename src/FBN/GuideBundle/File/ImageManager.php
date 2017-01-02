<?php

namespace FBN\GuideBundle\File;

use Symfony\Component\HttpFoundation\File\File;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Storage\StorageInterface;
use FBN\GuideBundle\Entity\TutorialChapter;

class ImageManager
{
    /**
     * Needed for images name permutation (without file uploading - i.e Tutorial backend with JS).
     */
    const TEMPORARY_FILE_PREFIX = 'tmp-file-prefix-';

    /**
     * @var CacheManager
     */
    private $cacheManager;

    /**
     * @var StorageInterface
     */
    private $fileSystemStorage;

    /**
     * Stores all path to images files upload directories (absolute path from Vich config).
     *
     * @var array
     */
    private $mappings = array();

    /**
     * Stores all path to images files to be deleted at the end of the renaming process (absolute path).
     *
     * @var array
     */
    private $originalFilesToBeDeleted = array();

    public function __construct(CacheManager $cacheManager, StorageInterface $fileSystemStorage, $mappings)
    {
        $this->cacheManager = $cacheManager;
        $this->fileSystemStorage = $fileSystemStorage;
        $this->mappings = $mappings;
    }

    /**
     * Rename Image file from related Entity (Article) onFlush event.
     *
     * @param object $entity the entity
     * @param object $em     the entity manager
     * @param object $uow    the unit of work
     */
    public function renameImageFileFromArticleOnFlush($entity, $em, $uow)
    {
        // An array is needed to manage collections of entities have having a one to one relation with an image entity.
        $images = array();

        // Entities with a one to one relation with an image entity.
        if (property_exists($entity, 'image')) {
            $images[] = $image = $entity->getImage();
        // Entities with a one to many relation with an entity having a one to one relation with an image entity.
        } elseif ($entity instanceof TutorialChapter) {
            if (null !== $entity->getTutorialChapterParas()) {
                foreach ($entity->getTutorialChapterParas() as $tutorialChapterPara) {
                    $images[] = $tutorialChapterPara->getImage();
                }
            }
        }

        foreach ($images as $image) {
            if ((null !== $image)) {
                $this->renameImageFile($image);

                $classMetadata = $em->getClassMetadata(get_class($image));
                $uow->recomputeSingleEntityChangeSet($classMetadata, $image);
            }
        }

        unset($images);

        return;
    }

    /**
     * Rename Image file.
     *
     * @param object $image the image entity
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
                $updatedTemporaryName = self::TEMPORARY_FILE_PREFIX.$updatedRootName.'.'.strtolower($extension);
                $absolutePathToTemporaryFile = $fileDirectory.DIRECTORY_SEPARATOR.$updatedTemporaryName;
                $absolutePathToUpdatedFile = $fileDirectory.DIRECTORY_SEPARATOR.$updatedName;

                copy($absolutePathToActualFile, $absolutePathToTemporaryFile);
                $this->originalFilesToBeDeleted[] = $absolutePathToActualFile;

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
     * @param object $image the image entity
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
     * @param object $image the entity
     */
    public function removeEntityRelatedCachedFile($image)
    {
        $relativePathToActualFile = $image->getRelativePathToActualFile();

        if (null !== $relativePathToActualFile) {
            $this->cacheManager->remove($relativePathToActualFile);
        }

        return;
    }

    /**
     * Rename temporary image files created during the images files renaming process on post flush event.
     */
    public function renameTemporaryFiles()
    {
        $uploadDirectories = array();
        foreach ($this->mappings as $mapping) {
            $uploadDirectories[] = $mapping['upload_destination'];
        }
        array_unique($uploadDirectories);

        // Renames files.
        foreach ($uploadDirectories as $uploadDirectory) {
            $files = scandir($uploadDirectory);
            foreach ($files as $file) {
                if (false !== strpos($file, self::TEMPORARY_FILE_PREFIX)) {
                    $absolutePathToActualFile = $uploadDirectory.DIRECTORY_SEPARATOR.$file;
                    $renamedFile = str_replace(self::TEMPORARY_FILE_PREFIX, '', $file);
                    $absolutePathToRenamedFile = $uploadDirectory.DIRECTORY_SEPARATOR.$renamedFile;
                    // Updates files list to be deleted.
                    if (false !== $key = array_search($absolutePathToRenamedFile, $this->originalFilesToBeDeleted)) {
                        unset($this->originalFilesToBeDeleted[$key]);
                    }
                    rename($absolutePathToActualFile, $absolutePathToRenamedFile);
                }
            }
        }

        // Deletes original unusued files.
        foreach ($this->originalFilesToBeDeleted as $key => $originalFileToBeDeleted) {
            unset($this->originalFilesToBeDeleted[$key]);
            if (file_exists($originalFileToBeDeleted)) {
                unlink($originalFileToBeDeleted);
            }
        }
    }
}
