<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * TutorielChapitre
 *
 * @ORM\Table(name="tutorielchapitre")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\TutorielChapitreRepository")
 */
class TutorielChapitre
{

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Tutoriel", inversedBy="tutorielChapitre")
   * @ORM\JoinColumn(nullable=false)
   */
  private $tutoriel;       

  /**
   * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\TutorielChapitrePara", mappedBy="tutorielChapitre")
   * @ORM\OrderBy({"rank" = "ASC"})
   */
  private $tutorielChapitrePara; 
 

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
     * @ORM\Column(name="titre", type="string", length=255)
     * @Gedmo\Translatable          
     */
    private $titre;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Chapitre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return TutorielChapitre
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
     * Set tutoriel
     *
     * @param \FBN\GuideBundle\Entity\Tutoriel $tutoriel
     * @return TutorielChapitre
     */
    public function setTutoriel(\FBN\GuideBundle\Entity\Tutoriel $tutoriel)
    {
        $this->tutoriel = $tutoriel;

        return $this;
    }

    /**
     * Get tutoriel
     *
     * @return \FBN\GuideBundle\Entity\Tutoriel 
     */
    public function getTutoriel()
    {
        return $this->tutoriel;
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
     * Add tutorielChapitrePara
     *
     * @param \FBN\GuideBundle\Entity\TutorielChapitrePara $tutorielChapitrePara
     * @return Vigneron
     */
    public function addTutorielChapitrePara(\FBN\GuideBundle\Entity\TutorielChapitrePara $tutorielChapitrePara)
    {
        $this->tutorielChapitrePara[] = $tutorielChapitrePara;
        $tutorielChapitrePara->setVigneron($this); 

        return $this;
    }

    /**
     * Remove tutorielChapitrePara
     *
     * @param \FBN\GuideBundle\Entity\TutorielChapitrePara $tutorielChapitrePara
     */
    public function removeTutorielChapitrePara(\FBN\GuideBundle\Entity\TutorielChapitrePara $tutorielChapitrePara)
    {
        $this->tutorielChapitrePara->removeElement($tutorielChapitrePara);
    }

    /**
     * Get tutorielChapitrePara
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTutorielChapitrePara()
    {
        return $this->tutorielChapitrePara;
    }

}
