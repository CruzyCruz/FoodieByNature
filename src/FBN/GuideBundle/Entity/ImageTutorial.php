<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ImageTutorial.
 *
 * @ORM\Table(name="image_tutorial")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\ImageTutorialRepository")
 * @Vich\Uploadable
 */
class ImageTutorial extends Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Tutorial", mappedBy="image")
     */
    private $tutorial;

    /**
     * @Vich\UploadableField(mapping="image_tutorial", fileNameProperty="name")
     * @Assert\Expression("this.getFile() or this.getName()", message="fbn.guide.admin.image.upload")
     * @Assert\Image(
     *     maxSize = "300k",
     *     mimeTypes = {"image/jpeg"},
     *     mimeTypesMessage = "fbn.guide.admin.image.mimeType",
     *     minWidth = 672,
     *     maxWidth = 672,
     *     minHeight = 469,
     *     maxHeight = 469
     * )
     *
     * @var File
     */
    protected $file;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tutorial.
     *
     * @param \FBN\GuideBundle\Entity\Tutorial $tutorial
     *
     * @return ImageTutorial
     */
    public function setTutorial(\FBN\GuideBundle\Entity\Tutorial $tutorial)
    {
        $this->tutorial = $tutorial;

        return $this;
    }

    /**
     * Get tutorial.
     *
     * @return \FBN\GuideBundle\Entity\Tutorial
     */
    public function getTutorial()
    {
        return $this->tutorial;
    }

    /**
     * Build Image name.
     *
     * @return null|string
     */
    public function buildImageRootName()
    {
        if (null !== $this->getTutorial()) {
            return $this->getTutorial()->getSlug();
        }

        return;
    }
}
