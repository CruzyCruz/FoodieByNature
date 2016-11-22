<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Restaurant.
 *
 * @ORM\Table(name="restaurant")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\RestaurantRepository")
 * @Gedmo\TranslationEntity(class="FBN\GuideBundle\Entity\Translation\RestaurantTranslation")
 */
class Restaurant extends Article
{
    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\RestaurantPrice")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $restaurantPrice;

    /**
     * @ORM\ManyToMany(targetEntity="FBN\GuideBundle\Entity\RestaurantStyle")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $restaurantStyle;

    /**
     * @ORM\ManyToMany(targetEntity="FBN\GuideBundle\Entity\RestaurantBonus")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $restaurantBonus;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\ImageRestaurant", inversedBy="restaurant", cascade={"persist","remove"})  
     * @Assert\Valid()
     */
    private $image;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Coordinates", inversedBy="restaurant", cascade={"persist","remove"})
     * @Assert\Valid()
     */
    private $coordinates;

    /**
     * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\Event", mappedBy="restaurant")
     */
    private $event;

    /**
     * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\Bookmark", mappedBy="restaurant", cascade={"remove"})
     */
    private $bookmark;

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
     * @ORM\Column(name="owner", type="string", length=255)
     * @Assert\NotBlank()
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
     * @Assert\Url(protocols = {"http", "https"})
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
     * @var string
     *
     * @ORM\Column(name="slugFromCoordinatesISO", type="string", length=128)
     */
    private $slugFromCoordinatesISO;

    /**
     * @var string
     * 
     * @Gedmo\Slug(separator="-", updatable=true, fields={"name","slugFromCoordinatesISO"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var bool
     *
     * @ORM\Column(name="isShop", type="boolean")
     */
    private $isShop;

    public function __construct()
    {
        parent::__construct();
        $this->restaurantStyle = new \Doctrine\Common\Collections\ArrayCollection();
        $this->restaurantBonus = new \Doctrine\Common\Collections\ArrayCollection();
        $this->event = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Restaurant
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
     * Set openingHours.
     *
     * @param string $openingHours
     *
     * @return Restaurant
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
     * Set restaurantPrice.
     *
     * @param \FBN\GuideBundle\Entity\RestaurantPrice $restaurantPrice
     *
     * @return Restaurant
     */
    public function setRestaurantPrice(\FBN\GuideBundle\Entity\RestaurantPrice $restaurantPrice)
    {
        $this->restaurantPrice = $restaurantPrice;

        return $this;
    }

    /**
     * Get restaurantPrice.
     *
     * @return \FBN\GuideBundle\Entity\RestaurantPrice
     */
    public function getRestaurantPrice()
    {
        return $this->restaurantPrice;
    }

    /**
     * Add restaurantStyle.
     *
     * @param \FBN\GuideBundle\Entity\RestaurantStyle $restaurantStyle
     *
     * @return Restaurant
     */
    public function addRestaurantStyle(\FBN\GuideBundle\Entity\RestaurantStyle $restaurantStyle)
    {
        $this->restaurantStyle[] = $restaurantStyle;

        return $this;
    }

    /**
     * Remove restaurantStyle.
     *
     * @param \FBN\GuideBundle\Entity\RestaurantStyle $restaurantStyle
     */
    public function removeRestaurantStyle(\FBN\GuideBundle\Entity\RestaurantStyle $restaurantStyle)
    {
        $this->restaurantStyle->removeElement($restaurantStyle);
    }

    /**
     * Get restaurantStyle.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRestaurantStyle()
    {
        return $this->restaurantStyle;
    }

    /**
     * Add restaurantBonus.
     *
     * @param \FBN\GuideBundle\Entity\RestaurantBonus $restaurantBonus
     *
     * @return Restaurant
     */
    public function addRestaurantBonus(\FBN\GuideBundle\Entity\RestaurantBonus $restaurantBonus)
    {
        $this->restaurantBonus[] = $restaurantBonus;

        return $this;
    }

    /**
     * Remove restaurantBonus.
     *
     * @param \FBN\GuideBundle\Entity\RestaurantBonus $restaurantBonus
     */
    public function removeRestaurantBonus(\FBN\GuideBundle\Entity\RestaurantBonus $restaurantBonus)
    {
        $this->restaurantBonus->removeElement($restaurantBonus);
    }

    /**
     * Get restaurantBonus.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRestaurantBonus()
    {
        return $this->restaurantBonus;
    }

    /**
     * Set image.
     *
     * @param \FBN\GuideBundle\Entity\ImageRestaurant $image
     *
     * @return Restaurant
     */
    public function setImage(\FBN\GuideBundle\Entity\ImageRestaurant $image)
    {
        $this->image = $image;
        $image->setRestaurant($this);

        return $this;
    }

    /**
     * Get image.
     *
     * @return \FBN\GuideBundle\Entity\ImageRestaurant
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set coordinates.
     *
     * @param \FBN\GuideBundle\Entity\Coordinates $coordinates
     *
     * @return Restaurant
     */
    public function setCoordinates(\FBN\GuideBundle\Entity\Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;
        $coordinates->setRestaurant($this);

        return $this;
    }

    /**
     * Get coordinates.
     *
     * @return \FBN\GuideBundle\Entity\Coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Get event.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set tel.
     *
     * @param string $tel
     *
     * @return Restaurant
     */
    public function setTel($tel = null)
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
     * @return Restaurant
     */
    public function setSite($site = null)
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
     * @return Restaurant
     */
    public function setHref($href = null)
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
     * Set slug.
     *
     * @param string $slug
     *
     * @return Restaurant
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
     * Set slugFromCoordinatesISO.
     *
     * @param string $slugFromCoordinatesISO
     *
     * @return Restaurant
     */
    public function setSlugFromCoordinatesISO($slugFromCoordinatesISO)
    {
        $this->slugFromCoordinatesISO = $slugFromCoordinatesISO;

        return $this;
    }

    /**
     * Get slugFromCoordinatesISO.
     *
     * @return string
     */
    public function getSlugFromCoordinatesISO()
    {
        return $this->slugFromCoordinatesISO;
    }

    /**
     * Set isShop.
     *
     * @param bool $isShop
     *
     * @return Restaurant
     */
    public function setIsShop($isShop)
    {
        $this->isShop = $isShop;

        return $this;
    }

    /**
     * Get isShop.
     *
     * @return bool
     */
    public function getIsShop()
    {
        return $this->isShop;
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getCoordinates()->__toString().' / '.$this->getName();
    }
}
