<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ImageWinemaker.
 *
 * @ORM\Table(name="image_winemaker")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\ImageWinemakerRepository")
 * @Vich\Uploadable
 */
class ImageWinemaker extends Image
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
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Winemaker", mappedBy="image")
     */
    private $winemaker;

    /**
     * @Vich\UploadableField(mapping="image_winemaker", fileNameProperty="name")
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
     * Set winemaker.
     *
     * @param \FBN\GuideBundle\Entity\Winemaker $winemaker
     *
     * @return ImageWinemaker
     */
    public function setWinemaker(\FBN\GuideBundle\Entity\Winemaker $winemaker)
    {
        $this->winemaker = $winemaker;

        return $this;
    }

    /**
     * Get winemaker.
     *
     * @return \FBN\GuideBundle\Entity\Winemaker
     */
    public function getWinemaker()
    {
        return $this->winemaker;
    }

    /**
     * Build Image name.
     *
     * @return null|string
     */
    public function buildImageRootName()
    {
        if (null !== $this->getWinemaker()) {
            return $this->getWinemaker()->getSlug();
        }

        return;
    }
}
