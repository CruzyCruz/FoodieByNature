<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\EvenementRepository")
 * @Gedmo\TranslationEntity(class="FBN\GuideBundle\Entity\Translation\EvenementTranslation") 
 */
class Evenement extends Article
{

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\EvenementType")
   * @ORM\JoinColumn(nullable=false)
   */
  private $evenementType; 

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
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\VigneronDomaine")
   * @ORM\JoinColumn(nullable=true)
   */
  private $vigneronDomaine;

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Coordonnees", cascade={"persist"})
   * @ORM\JoinColumn(nullable=true)
   */
  private $coordonnees;    

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Evenement")
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
   */
  private $evenementPast;  

    /**
     * @var integer
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
     * @ORM\Column(name="annee", type="string", length=255)
     */
    private $annee;

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
    *
    * @var boolean
    *
    * @ORM\Column(name="useExtTel", type="boolean")
    */
    private $useExtTel;

    /**
    *
    * @var boolean
    *
    * @ORM\Column(name="useExtSite", type="boolean")
    */
    private $useExtSite;    

    /**
     * @Gedmo\Slug(fields={"name","annee"}, prefix="evenement-")
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param string $date
     * @return Evenement
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    } 

    /**
     * Set annee
     *
     * @param string $annee
     * @return Evenement
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return string 
     */
    public function getAnnee()
    {
        return $this->annee;
    }    

    /**
     * Set openingHours
     *
     * @param string $openingHours
     * @return Evenement
     */
    public function setOpeningHours($openingHours)
    {
        $this->openingHours = $openingHours;

        return $this;
    }

    /**
     * Get openingHours
     *
     * @return string 
     */
    public function getOpeningHours()
    {
        return $this->openingHours;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Evenement
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set evenementType
     *
     * @param \FBN\GuideBundle\Entity\EvenementType $evenementType
     * @return Evenement
     */
    public function setEvenementType(\FBN\GuideBundle\Entity\EvenementType $evenementType)
    {
        $this->evenementType = $evenementType;

        return $this;
    }

    /**
     * Get restaurant
     *
     * @return \FBN\GuideBundle\Entity\EvenementType 
     */
    public function getEvenementType()
    {
        return $this->evenementType;
    }


    /**
     * Set image
     *
     * @param \FBN\GuideBundle\Entity\Image $image
     * @return Evenement
     */
    public function setImage(\FBN\GuideBundle\Entity\Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \FBN\GuideBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set restaurant
     *
     * @param \FBN\GuideBundle\Entity\Restaurant $restaurant
     * @return Evenement
     */
    public function setRestaurant(\FBN\GuideBundle\Entity\Restaurant $restaurant = null)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * Get restaurant
     *
     * @return \FBN\GuideBundle\Entity\Restaurant 
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * Set caviste
     *
     * @param \FBN\GuideBundle\Entity\caviste $caviste
     * @return Evenement
     */
    public function setCaviste(\FBN\GuideBundle\Entity\caviste $caviste = null)
    {
        $this->caviste = $caviste;

        return $this;
    }

    /**
     * Get caviste
     *
     * @return \FBN\GuideBundle\Entity\caviste 
     */
    public function getCaviste()
    {
        return $this->caviste;
    }    

    /**
     * Set vigneronDomaine
     *
     * @param \FBN\GuideBundle\Entity\VigneronDomaine $vigneronDomaine
     * @return Evenement
     */
    public function setVigneronDomaine(\FBN\GuideBundle\Entity\VigneronDomaine $vigneronDomaine = null)
    {
        $this->vigneronDomaine = $vigneronDomaine;

        return $this;
    }

    /**
     * Get vigneronDomaine
     *
     * @return \FBN\GuideBundle\Entity\VigneronDomaine 
     */
    public function getVigneronDomaine()
    {
        return $this->vigneronDomaine;
    }

    /**
     * Set coordonnees
     *
     * @param \FBN\GuideBundle\Entity\Coordonnees $coordonnees
     * @return Evenement
     */
    public function setCoordonnees(\FBN\GuideBundle\Entity\Coordonnees $coordonnees = null)
    {
        $this->coordonnees = $coordonnees;

        return $this;
    }

    /**
     * Get coordonnees
     *
     * @return \FBN\GuideBundle\Entity\Coordonnees 
     */
    public function getCoordonnees()
    {
        return $this->coordonnees;
    }

    /**
     * Set evenementPast
     *
     * @param \FBN\GuideBundle\Entity\evenement $evenement
     * @return Evenement
     */
    public function setEvenementPast(\FBN\GuideBundle\Entity\Evenement $evenement = null)
    {
        $this->evenementPast = $evenement;

        return $this;
    }

    /**
     * Get evenement
     *
     * @return \FBN\GuideBundle\Entity\evenement 
     */
    public function getEvenementPast()
    {
        return $this->evenementPast;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return Coordonnees
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set site
     *
     * @param string $site
     * @return Evenement
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set href
     *
     * @param string $href
     * @return Evenement
     */
    public function setHref($href)
    {
        $this->href = $href;

        return $this;
    }

    /**
     * Get href
     *
     * @return string 
     */
    public function getHref()
    {
        return $this->href;
    }  

    /**
     * Set useExtTel
     *
     * @param boolean $useExtTel
     * @return Evenement
     */
    public function setUseExtTel($useExtTel)
    {
        $this->useExtTel = $useExtTel;

        return $this;
    }

    /**
     * Get useExtTel
     *
     * @return boolean 
     */
    public function getUseExtTel()
    {
        return $this->useExtTel;
    }

    /**
     * Set useExtSite
     *
     * @param boolean $useExtSite
     * @return Evenement
     */
    public function setUseExtSite($useExtSite)
    {
        $this->useExtSite = $useExtSite;

        return $this;
    }

    /**
     * Get useExtSite
     *
     * @return boolean 
     */
    public function getUseExtSite()
    {
        return $this->useExtSite;
    }    

    /**
     * Set locale
     *
     * @param string $locale
     * 
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }        
}
