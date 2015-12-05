<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Event.
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\EventRepository")
 * @Gedmo\TranslationEntity(class="FBN\GuideBundle\Entity\Translation\EventTranslation") 
 */
class Event extends Article
{
    /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\EventType")
   * @ORM\JoinColumn(nullable=false)
   */
  private $eventType;

  /**
   * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Image", cascade={"persist"})
   * @ORM\JoinColumn(nullable=true)
   */
  private $image;

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Restaurant")
   * @ORM\JoinColumn(nullable=true)
   */
  private $restaurant;

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Shop")
   * @ORM\JoinColumn(nullable=true)
   */
  private $shop;

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\WinemakerDomain")
   * @ORM\JoinColumn(nullable=true)
   */
  private $winemakerDomain;

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Coordinates", cascade={"persist"})
   * @ORM\JoinColumn(nullable=true)
   */
  private $coordinates;

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Event")
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
   */
  private $eventPast;

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
     * @ORM\Column(name="date", type="string", length=255)
     * @Gedmo\Translatable      
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="year", type="string", length=255)
     */
    private $year;

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
     * @var bool
     *
     * @ORM\Column(name="useExtTel", type="boolean")
     */
    private $useExtTel;

    /**
     * @var bool
     *
     * @ORM\Column(name="useExtSite", type="boolean")
     */
    private $useExtSite;

    /**
     * @Gedmo\Slug(fields={"name","year"}, prefix="event-")
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

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
     * Set date.
     *
     * @param string $date
     *
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set year.
     *
     * @param string $year
     *
     * @return Event
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year.
     *
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set openingHours.
     *
     * @param string $openingHours
     *
     * @return Event
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
     * @return Event
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
     * Set eventType.
     *
     * @param \FBN\GuideBundle\Entity\EventType $eventType
     *
     * @return Event
     */
    public function setEventType(\FBN\GuideBundle\Entity\EventType $eventType)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * Get restaurant.
     *
     * @return \FBN\GuideBundle\Entity\EventType
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * Set image.
     *
     * @param \FBN\GuideBundle\Entity\Image $image
     *
     * @return Event
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
     * @return Event
     */
    public function setRestaurant(\FBN\GuideBundle\Entity\Restaurant $restaurant = null)
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
     * Set shop.
     *
     * @param \FBN\GuideBundle\Entity\shop $shop
     *
     * @return Event
     */
    public function setShop(\FBN\GuideBundle\Entity\shop $shop = null)
    {
        $this->shop = $shop;

        return $this;
    }

    /**
     * Get shop.
     *
     * @return \FBN\GuideBundle\Entity\shop
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * Set winemakerDomain.
     *
     * @param \FBN\GuideBundle\Entity\WinemakerDomain $winemakerDomain
     *
     * @return Event
     */
    public function setWinemakerDomain(\FBN\GuideBundle\Entity\WinemakerDomain $winemakerDomain = null)
    {
        $this->winemakerDomain = $winemakerDomain;

        return $this;
    }

    /**
     * Get winemakerDomain.
     *
     * @return \FBN\GuideBundle\Entity\WinemakerDomain
     */
    public function getWinemakerDomain()
    {
        return $this->winemakerDomain;
    }

    /**
     * Set coordinates.
     *
     * @param \FBN\GuideBundle\Entity\Coordinates $coordinates
     *
     * @return Event
     */
    public function setCoordinates(\FBN\GuideBundle\Entity\Coordinates $coordinates = null)
    {
        $this->coordinates = $coordinates;

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
     * Set eventPast.
     *
     * @param \FBN\GuideBundle\Entity\event $event
     *
     * @return Event
     */
    public function setEventPast(\FBN\GuideBundle\Entity\Event $event = null)
    {
        $this->eventPast = $event;

        return $this;
    }

    /**
     * Get event.
     *
     * @return \FBN\GuideBundle\Entity\event
     */
    public function getEventPast()
    {
        return $this->eventPast;
    }

    /**
     * Set tel.
     *
     * @param string $tel
     *
     * @return Coordinates
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
     * @return Event
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
     * @return Event
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
     * Set useExtTel.
     *
     * @param bool $useExtTel
     *
     * @return Event
     */
    public function setUseExtTel($useExtTel)
    {
        $this->useExtTel = $useExtTel;

        return $this;
    }

    /**
     * Get useExtTel.
     *
     * @return bool
     */
    public function getUseExtTel()
    {
        return $this->useExtTel;
    }

    /**
     * Set useExtSite.
     *
     * @param bool $useExtSite
     *
     * @return Event
     */
    public function setUseExtSite($useExtSite)
    {
        $this->useExtSite = $useExtSite;

        return $this;
    }

    /**
     * Get useExtSite.
     *
     * @return bool
     */
    public function getUseExtSite()
    {
        return $this->useExtSite;
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
