<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Tutoriel
 *
 * @ORM\Table(name="tutoriel")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\TutorielRepository")
 */
class Tutoriel extends Article
{

  /**
   * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\TutorielChapitre", mappedBy="tutoriel")
   * @ORM\OrderBy({"rang" = "ASC"})
   */
  private $tutorielChapitre;     

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image; 

    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\TutorielRubrique", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tutorielRubrique;        

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="rang", type="integer")
     */
    private $rang;  

    /**
     * @var string
     *
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;  

    /**
     * @Gedmo\Slug(fields={"name"}, prefix="tutoriel-")
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;   


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
     * Set rang
     *
     * @param integer $rang
     * @return Tutoriel
     */
    public function setRang($rang)
    {
        $this->rang = $rang;

        return $this;
    }

    /**
     * Get rang
     *
     * @return integer 
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Tutoriel
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
     * Set image
     *
     * @param \FBN\GuideBundle\Entity\Image $image
     * @return Tutoriel
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
     * Set tutorielRubrique
     *
     * @param \FBN\GuideBundle\Entity\RestaurantPrix $tutorielRubrique
     * @return Restaurant
     */
    public function setTutorielRubrique(\FBN\GuideBundle\Entity\TutorielRubrique $tutorielRubrique)
    {
        $this->tutorielRubrique = $tutorielRubrique;

        return $this;
    }

    /**
     * Get tutorielRubrique
     *
     * @return \FBN\GuideBundle\Entity\TutorielRubrique 
     */
    public function getTutorielRubrique()
    {
        return $this->tutorielRubrique;
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

    /**
     * Add tutorielChapitre
     *
     * @param \FBN\GuideBundle\Entity\TutorielChapitre $tutorielChapitre
     * @return Vigneron
     */
    public function addTutorielChapitre(\FBN\GuideBundle\Entity\TutorielChapitre $tutorielChapitre)
    {
        $this->tutorielChapitre[] = $tutorielChapitre;
        $tutorielChapitre->setVigneron($this); 

        return $this;
    }

    /**
     * Remove tutorielChapitre
     *
     * @param \FBN\GuideBundle\Entity\TutorielChapitre $tutorielChapitre
     */
    public function removeTutorielChapitre(\FBN\GuideBundle\Entity\TutorielChapitre $tutorielChapitre)
    {
        $this->tutorielChapitre->removeElement($tutorielChapitre);
    }

    /**
     * Get tutorielChapitre
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTutorielChapitre()
    {
        return $this->tutorielChapitre;
    }    
}
