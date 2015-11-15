<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Vigneron", inversedBy="winemakerDomain")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vigneron;

    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\WinemakerArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $winemakerArea;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Coordonnees", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $coordonnees;

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
    public function setDomain($domain)
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
     * @return Vigneron
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
     * @return Vigneron
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
     * @return Vigneron
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
     * Set locale.
     *
     * @param string $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Set vigneron.
     *
     * @param \FBN\GuideBundle\Entity\Vigneron $vigneron
     *
     * @return WinemakerDomain
     */
    public function setVigneron(\FBN\GuideBundle\Entity\Vigneron $vigneron)
    {
        $this->vigneron = $vigneron;

        return $this;
    }

    /**
     * Get vigneron.
     *
     * @return \FBN\GuideBundle\Entity\Vigneron
     */
    public function getVigneron()
    {
        return $this->vigneron;
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
     * Set coordonnees.
     *
     * @param \FBN\GuideBundle\Entity\Coordonnees $coordonnees
     *
     * @return WinemakerDomain
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
}
