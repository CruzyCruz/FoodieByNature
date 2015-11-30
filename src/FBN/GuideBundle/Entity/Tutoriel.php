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
   * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\TutorialChapter", mappedBy="tutoriel")
   * @ORM\OrderBy({"rank" = "ASC"})
   */
  private $tutorialChapter;     

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
     * @ORM\Column(name="rank", type="integer")
     */
    private $rank;  

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
     * Set rank
     *
     * @param integer $rank
     * @return Tutoriel
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
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
     * @param \FBN\GuideBundle\Entity\RestaurantPrice $tutorielRubrique
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
     * Add tutorialChapter
     *
     * @param \FBN\GuideBundle\Entity\TutorialChapter $tutorialChapter
     * @return Winemaker
     */
    public function addTutorialChapter(\FBN\GuideBundle\Entity\TutorialChapter $tutorialChapter)
    {
        $this->tutorialChapter[] = $tutorialChapter;
        $tutorialChapter->setWinemaker($this); 

        return $this;
    }

    /**
     * Remove tutorialChapter
     *
     * @param \FBN\GuideBundle\Entity\TutorialChapter $tutorialChapter
     */
    public function removeTutorialChapter(\FBN\GuideBundle\Entity\TutorialChapter $tutorialChapter)
    {
        $this->tutorialChapter->removeElement($tutorialChapter);
    }

    /**
     * Get tutorialChapter
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTutorialChapter()
    {
        return $this->tutorialChapter;
    }    
}
