<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Event.
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\EventRepository")
 * @Gedmo\TranslationEntity(class="FBN\GuideBundle\Entity\Translation\EventTranslation")
 * @ORM\HasLifecycleCallbacks()
 */
class Event extends Article
{
    const NUM_ITEMS = 8;
        
    private static $eventLocationAttributes = array('coordinates', 'restaurant', 'shop', 'winemakerDomain', 'eventPast');

    /**
     * @var FBN\UserBundle\Entity\User
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="FBN\UserBundle\Entity\User", inversedBy="events")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $articleOwner;

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\EventType")
   * @ORM\JoinColumn(nullable=false)
   */
  private $eventType;

  /**
   * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\ImageEvent",  inversedBy="event", cascade={"persist","remove"})
   * @ORM\JoinColumn(nullable=false)
   * @Assert\Valid()
   */
  private $image;

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Restaurant", inversedBy="event")
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
   */
  private $restaurant;

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Shop", inversedBy="event")
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
   */
  private $shop;

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\WinemakerDomain", inversedBy="event")
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
   */
  private $winemakerDomain;

  /**
   * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Coordinates", inversedBy="event", cascade={"persist","remove"}, orphanRemoval=true)
   * @Assert\Valid()
   */
  private $coordinates;

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Event", inversedBy="event")
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
   */
  private $eventPast;

    /**
     * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\Event", mappedBy="eventPast", orphanRemoval=true)
     */
    private $event;

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
     * @ORM\Column(name="dateStart", type="date")
     */
    private $dateStart;

    /**
     * @var string
     *
     * @ORM\Column(name="dateEnd", type="date")
     */
    private $dateEnd;

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
     * @Assert\NotBlank()
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
     * @var string
     *
     * @ORM\Column(name="slugFromCoordinatesISO", type="string", length=128)
     */
    private $slugFromCoordinatesISO;

    /**
     * @Gedmo\Translatable
     * @Gedmo\Slug(updatable=true, fields={"name", "slugFromCoordinatesISO", "year"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="formerLocationCoordinates", type="string", length=255, nullable=true)
     */
    private $formerLocationCoordinates;

    /**
     * @var string
     *
     * @ORM\Column(name="formerLocationName", type="string", length=255, nullable=true)
     */
    private $formerLocationName;

    /**
     * @var string
     *
     * @ORM\Column(name="formerLocation", type="string", length=255, nullable=true)
     */
    private $formerLocation;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
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
     * Set dateStart.
     *
     * @param string $dateStart
     *
     * @return Event
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart.
     *
     * @return string
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd.
     *
     * @param string $dateEnd
     *
     * @return Event
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd.
     *
     * @return string
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
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
     * Set slugFromCoordinatesISO.
     *
     * @param string $slugFromCoordinatesISO
     *
     * @return Event
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
     * @param \FBN\GuideBundle\Entity\ImageEvent $image
     *
     * @return Event
     */
    public function setImage(\FBN\GuideBundle\Entity\ImageEvent $image)
    {
        $this->image = $image;
        $image->setEvent($this);

        return $this;
    }

    /**
     * Get image.
     *
     * @return \FBN\GuideBundle\Entity\ImageEvent
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
        // if coordinates is null, the corresponding coordinates entity will be removed by orphanRemoval mechanism
        if (null !== $coordinates) {
            $coordinates->setEvent($this);
        }

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
    public function setEventPast(\FBN\GuideBundle\Entity\Event $eventPast = null)
    {
        $this->eventPast = $eventPast;

        return $this;
    }

    /**
     * Get eventPast.
     *
     * @return \FBN\GuideBundle\Entity\event
     */
    public function getEventPast()
    {
        return $this->eventPast;
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
     * @return Coordinates
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
     * @return Event
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
     * @return Event
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
     * Set formerLocationCoordinates.
     *
     * @param string $formerLocationCoordinates
     *
     * @return Event
     */
    public function setFormerLocationCoordinates($formerLocationCoordinates)
    {
        $this->formerLocationCoordinates = $formerLocationCoordinates;

        return $this;
    }

    /**
     * Get formerLocationCoordinates.
     *
     * @return string
     */
    public function getFormerLocationCoordinates()
    {
        return $this->formerLocationCoordinates;
    }

    /**
     * Set formerLocationName.
     *
     * @param string $formerLocationName
     *
     * @return Event
     */
    public function setFormerLocationName($formerLocationName)
    {
        $this->formerLocationName = $formerLocationName;

        return $this;
    }

    /**
     * Get formerLocationName.
     *
     * @return string
     */
    public function getFormerLocationName()
    {
        return $this->formerLocationName;
    }

    /**
     * Set formerLocation.
     *
     * @param string $formerLocation
     *
     * @return Event
     */
    public function setFormerLocation($formerLocation)
    {
        $this->formerLocation = $formerLocation;

        return $this;
    }

    /**
     * Get formerLocation.
     *
     * @return string
     */
    public function getFormerLocation()
    {
        return $this->formerLocation;
    }

  /**
   * @ORM\PrePersist
   * @ORM\PreUpdate
   */
  public function defineYear()
  {
      $this->setYear($this->getDateStart()->format('Y'));
  }

    /**
     * @Assert\IsTrue(message = "fbn.guide.admin.event.isEventLocationValid").
     */
    public function isEventLocationValid()
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $nbEventLocation = 0;
        foreach (self::$eventLocationAttributes  as $eventLocationAttribute) {
            $nbEventLocation = $nbEventLocation + ($accessor->getValue($this, $eventLocationAttribute) === null ? 0 : 1);
        }

        // If no event location is defined or more than one.
        if ($nbEventLocation !== 1) {
            return false;
        }

        // If this event is referenced by one or several events, its coordinates should not be null.
        if (!($this->event->isEmpty()) && null === $this->getCoordinates()) {
            return false;
        }

        // If location is defined using coordinates but 'useExtTel' or 'useExtSite' are true
        if (null !== $accessor->getValue($this, 'coordinates')) {
            if ((true === $accessor->getValue($this, 'useExtTel')) || (true === $accessor->getValue($this, 'useExtSite'))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @Assert\IsTrue(message = "fbn.guide.admin.event.isEventDatesValid").
     */
    public function isEventDatesValid()
    {
        if ($this->dateStart > $this->dateEnd) {
            return false;
        }

        return true;
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getName().' / '.$this->getDateStart()->format('Y-m-d').' / ['.$this->findArticleOwner().']';
    }
}
