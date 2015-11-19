<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Evenement.
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\EvenementRepository")
 * @Gedmo\TranslationEntity(class="FBN\GuideBundle\Entity\Translation\EvenementTranslation") 
 */
class Evenement extends Article
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
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Caviste")
   * @ORM\JoinColumn(nullable=true)
   */
  private $caviste;

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\WinemakerDomain")
   * @ORM\JoinColumn(nullable=true)
   */
  private $winemakerDomain;

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Coordonnees", cascade={"persist"})
   * @ORM\JoinColumn(nullable=true)
   */
  private $coordonnees;

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Evenement")
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
     * @Gedmo\Slug(fields={"name","year"}, prefix="evenement-")
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
     * @return Evenement
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
     * @return Evenement
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
     * @return Evenement
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
     * @return Evenement
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
     * @return Evenement
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
     * @return Evenement
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
     * @return Evenement
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
     * Set caviste.
     *
     * @param \FBN\GuideBundle\Entity\caviste $caviste
     *
     * @return Evenement
     */
    public function setCaviste(\FBN\GuideBundle\Entity\caviste $caviste = null)
    {
        $this->caviste = $caviste;

        return $this;
    }

    /**
     * Get caviste.
     *
     * @return \FBN\GuideBundle\Entity\caviste
     */
    public function getCaviste()
    {
        return $this->caviste;
    }

    /**
     * Set winemakerDomain.
     *
     * @param \FBN\GuideBundle\Entity\WinemakerDomain $winemakerDomain
     *
     * @return Evenement
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
     * Set coordonnees.
     *
     * @param \FBN\GuideBundle\Entity\Coordonnees $coordonnees
     *
     * @return Evenement
     */
    public function setCoordonnees(\FBN\GuideBundle\Entity\Coordonnees $coordonnees = null)
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
     * Set eventPast.
     *
     * @param \FBN\GuideBundle\Entity\evenement $evenement
     *
     * @return Evenement
     */
    public function setEventPast(\FBN\GuideBundle\Entity\Evenement $evenement = null)
    {
        $this->eventPast = $evenement;

        return $this;
    }

    /**
     * Get evenement.
     *
     * @return \FBN\GuideBundle\Entity\evenement
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
     * @return Coordonnees
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
     * @return Evenement
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
     * @return Evenement
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
     * @return Evenement
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
     * @return Evenement
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
