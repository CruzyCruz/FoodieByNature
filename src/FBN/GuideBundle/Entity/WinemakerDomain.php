<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WinemakerDomain.
 *
 * @ORM\Table(name="winemakerdomain")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\WinemakerDomainRepository")
 * @Gedmo\TranslationEntity(class="FBN\GuideBundle\Entity\Translation\WinemakerDomainTranslation")  
 */
class WinemakerDomain
{
    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Winemaker", inversedBy="winemakerDomain")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $winemaker;

    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\WinemakerArea")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $winemakerArea;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Coordinates", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $coordinates;

    /**
     * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\Event", mappedBy="winemakerDomain")
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
     * @ORM\Column(name="domain", type="string", length=255, nullable=true)
     */
    private $domain;

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
     * @var string
     *
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    public function __construct()
    {
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
     * Set domain.
     *
     * @param string $domain
     *
     * @return WinemakerDomain
     */
    public function setDomain($domain = null)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain.
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set openingHours.
     *
     * @param string $openingHours
     *
     * @return Winemaker
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
     * @return Winemaker
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
     * @return Winemaker
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
     * Set locale.
     *
     * @param string $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Set winemaker.
     *
     * @param \FBN\GuideBundle\Entity\Winemaker $winemaker
     *
     * @return WinemakerDomain
     */
    public function setWinemaker(\FBN\GuideBundle\Entity\Winemaker $winemaker)
    {
        $this->winemaker = $winemaker;

        return $this;
    }

    /**
     * Get winemaker.
     *
     * @return \FBN\GuideBundle\Entity\Winemaker
     */
    public function getWinemaker()
    {
        return $this->winemaker;
    }

    /**
     * Set winemakerArea.
     *
     * @param \FBN\GuideBundle\Entity\WinemakerArea $winemakerArea
     *
     * @return WinemakerDomain
     */
    public function setWinemakerArea(\FBN\GuideBundle\Entity\WinemakerArea $winemakerArea)
    {
        $this->winemakerArea = $winemakerArea;

        return $this;
    }

    /**
     * Get winemakerArea.
     *
     * @return \FBN\GuideBundle\Entity\WinemakerArea
     */
    public function getWinemakerArea()
    {
        return $this->winemakerArea;
    }

    /**
     * Set coordinates.
     *
     * @param \FBN\GuideBundle\Entity\Coordinates $coordinates
     *
     * @return WinemakerDomain
     */
    public function setCoordinates(\FBN\GuideBundle\Entity\Coordinates $coordinates)
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
     * Add event.
     *
     * @param \FBN\GuideBundle\Entity\Event $event
     *
     * @return WinemakerDomain
     */
    public function addEvent(\FBN\GuideBundle\Entity\Event $event)
    {
        $this->event[] = $event;
        $event->setWinemakerDomain($this);

        return $this;
    }

    /**
     * Remove event.
     *
     * @param \FBN\GuideBundle\Entity\Event $event
     */
    public function removeEvent(\FBN\GuideBundle\Entity\Event $event)
    {
        $this->event->removeElement($event);
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

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getWinemaker()->getName().' / '.$this->getDomain().' / '.$this->getWinemakerArea()->getArea();
    }
}
