<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WinemakerArea.
 *
 * @ORM\Table(name="winemaker_area")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\WinemakerAreaRepository")
 */
class WinemakerArea
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
     * @var string
     *
     * @ORM\Column(name="area", type="string", length=255, unique=true)
     * @Gedmo\Translatable
     * @Assert\NotBlank()
     */
    private $area;

    /**
     * @var string
     *
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

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
     * Set area.
     *
     * @param string $area
     *
     * @return WinemakerArea
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area.
     *
     * @return string
     */
    public function getArea()
    {
        return $this->area;
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getArea();
    }
}
