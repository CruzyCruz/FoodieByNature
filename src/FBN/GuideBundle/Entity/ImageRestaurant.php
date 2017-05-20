<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ImageRestaurant.
 *
 * @ORM\Table(name="image_restaurant")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\ImageRestaurantRepository")
 * @Vich\Uploadable
 */
class ImageRestaurant extends Image
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
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Restaurant", mappedBy="image")
     */
    private $restaurant;

    /**
     * @Vich\UploadableField(mapping="image_restaurant", fileNameProperty="name")
     * @Assert\Expression("this.getFile() or this.getName()", message="fbn.guide.admin.image.upload")
     * @Assert\Image(
     *     maxSize = "300k",
     *     mimeTypes = {"image/jpeg"},
     *     mimeTypesMessage = "fbn.guide.admin.image.mimeType",
     *     minWidth = 100,
     *     maxWidth = 1000,
     *     minHeight = 100,
     *     maxHeight = 1000
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
     * Set restaurant.
     *
     * @param \FBN\GuideBundle\Entity\Restaurant $restaurant
     *
     * @return ImageRestaurant
     */
    public function setRestaurant(\FBN\GuideBundle\Entity\Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * Get restaurant.
     *
     * @return \FBN\GuideBundle\Entity\Restaurant
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * Build Image name.
     *
     * @return null|string
     */
    public function buildImageRootName()
    {
        if (null !== $this->getRestaurant()) {
            return $this->getRestaurant()->getSlug();
        }

        return;
    }
}
