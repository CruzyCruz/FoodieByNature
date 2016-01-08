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
}
