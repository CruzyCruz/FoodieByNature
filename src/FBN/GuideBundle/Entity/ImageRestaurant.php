<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

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
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $restaurant;

    /**
     * @Vich\UploadableField(mapping="image_restaurant", fileNameProperty="name")
     *
     * @var File
     */
    private $file;

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
     * Get Slug from associated entity.
     *
     * @return null|string
     */
    public function getSlugFromRelatedEntity()
    {
        if (null !== $this->getRestaurant()) {
            return $this->getRestaurant()->getSlug();
        }

        return;
    }
}
