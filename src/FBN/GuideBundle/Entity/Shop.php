<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Shop.
 *
 * @ORM\Table(name="shop")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\ShopRepository")
 */
class Shop extends Article
{
    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Coordinates", inversedBy="shop", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Assert\Valid()
     */
    private $coordinates;

    /**
     * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\Event", mappedBy="shop")
     */
    private $event;

    /**
     * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\Bookmark", mappedBy="shop", cascade={"remove"})
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
     * @ORM\Column(name="owner", type="string", length=255, nullable=false)
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
     */
    private $href;

    /**
     * @var string
     *
     * @ORM\Column(name="openingHours", type="string", length=255)
     * @Gedmo\Translatable
     * @Assert\NotBlank()
     */
    private $openingHours;

    /**
     * @var string
     *
     * @ORM\Column(name="slugFromCoordinatesISO", type="string", length=128)
     */
    private $slugFromCoordinatesISO;

    /**
     * @Gedmo\Slug(updatable=true, fields={"name","slugFromCoordinatesISO"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    public function __construct()
    {
        parent::__construct();
        $this->event = new \Doctrine\Common\Collections\ArrayCollection();
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
        $coordinates->setShop($this);

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
     * Set restaurant.
     *
     * @param \FBN\GuideBundle\Entity\Restaurant $restaurant
     *
     * @return Shop
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
     * @return Shop
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
     * @return Shop
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
     * Set slugFromCoordinatesISO.
     *
     * @param string $slugFromCoordinatesISO
     *
     * @return Shop
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

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getCoordinates()->__toString().' / '.$this->getName();
    }
}
