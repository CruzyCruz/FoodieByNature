<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Caviste.
 *
 * @ORM\Table(name="caviste")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CavisteRepository")
 */
class Caviste extends Article
{
    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Coordonnees", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $coordonnees;

      /**
       * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Image", cascade={"persist"})
       * @ORM\JoinColumn(nullable=true)
       */
      private $image;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Restaurant", mappedBy="caviste")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $restaurant;

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
     * @ORM\Column(name="proprio", type="string", length=255, nullable=true)
     */
    private $proprio;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255, nullable=true)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=255, nullable=true)
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="href", type="string", length=255, nullable=true)
     */
    private $href;

    /**
     * @var string
     *
     * @ORM\Column(name="openingHours", type="string", length=255)
     * @Gedmo\Translatable     
     */
    private $openingHours;

    /**
     * @Gedmo\Slug(fields={"name"}, prefix="caviste-")
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /*public function __construct(\FBN\GuideBundle\Entity\Restaurant $restaurant)
    {
       parent::__construct();
       
       if (null != $restaurant)
       {
        $this->name = $restaurant->getName();
       }

    }*/

    /**
     * Set coordonnees.
     *
     * @param \FBN\GuideBundle\Entity\Coordonnees $coordonnees
     *
     * @return Restaurant
     */
    public function setCoordonnees(\FBN\GuideBundle\Entity\Coordonnees $coordonnees)
    {
        $this->coordonnees = $coordonnees;

        return $this;
    }

    /**
     * Get coordonnees.
     *
     * @return \FBN\GuideBundle\Entity\Coordonnees
     */
    public function getCoordonnees()
    {
        return $this->coordonnees;
    }

    /**
     * Set image.
     *
     * @param \FBN\GuideBundle\Entity\Image $image
     *
     * @return Restaurant
     */
    public function setImage(\FBN\GuideBundle\Entity\Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return \FBN\GuideBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set restaurant.
     *
     * @param \FBN\GuideBundle\Entity\Restaurant $restaurant
     *
     * @return Restaurant
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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set proprio.
     *
     * @param string $proprio
     *
     * @return proprio
     */
    public function setProprio($proprio)
    {
        $this->proprio = $proprio;

        return $this;
    }

    /**
     * Get proprio.
     *
     * @return string
     */
    public function getProprio()
    {
        return $this->proprio;
    }

    /**
     * Set tel.
     *
     * @param string $tel
     *
     * @return Caviste
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel.
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set site.
     *
     * @param string $site
     *
     * @return Caviste
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site.
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set href.
     *
     * @param string $href
     *
     * @return Caviste
     */
    public function setHref($href)
    {
        $this->href = $href;

        return $this;
    }

    /**
     * Get href.
     *
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * Set openingHours.
     *
     * @param string $openingHours
     *
     * @return Caviste
     */
    public function setOpeningHours($openingHours)
    {
        $this->openingHours = $openingHours;

        return $this;
    }

    /**
     * Get openingHours.
     *
     * @return string
     */
    public function getOpeningHours()
    {
        return $this->openingHours;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Caviste
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
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
}
