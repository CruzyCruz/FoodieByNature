<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * RestaurantStyle.
 *
 * @ORM\Table(name="restaurantstyle")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\RestaurantStyleRepository")
 */
class RestaurantStyle
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
     * @ORM\Column(name="style", type="string", length=255, unique=true)
     * @Gedmo\Translatable
     */
    private $style;

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
     * Set style.
     *
     * @param string $style
     *
     * @return RestaurantStyle
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Get style.
     *
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set locale.
     *
     * @param string $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getStyle();
    }
}
