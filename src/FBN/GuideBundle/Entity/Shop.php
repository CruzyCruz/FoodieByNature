<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Shop.
 *
 * @ORM\Table(name="shop")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\ShopRepository")
 */
class Shop extends Article
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
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Restaurant", mappedBy="shop")
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
     * @ORM\Column(name="owner", type="string", length=255, nullable=true)
     */
    private $owner;

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
     * @Gedmo\Slug(fields={"name"}, prefix="shop-")
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
     * Set owner.
     *
     * @param string $owner
     *
     * @return Shop
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner.
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set tel.
     *
     * @param string $tel
     *
     * @return Shop
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
     * @return Shop
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
     * @return Shop
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
     * @return Shop
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
     * @return Shop
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
