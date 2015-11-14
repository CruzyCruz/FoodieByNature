<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * TutorielChapitrePara
 *
 * @ORM\Table(name="tutorielchapitrepara")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\TutorielChapitreParaRepository")
 * @Gedmo\TranslationEntity(class="FBN\GuideBundle\Entity\Translation\TutorielChapitreParaTranslation") 
 */
class TutorielChapitrePara
{

    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\TutorielChapitre", inversedBy="tutorielChapitrePara")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tutorielChapitre;       
 
    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;    

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
     * @ORM\Column(name="paragraph", type="text")
     * @Gedmo\Translatable          
     */
    private $paragraph;

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
     * Set paragraph
     *
     * @param string $paragraph
     * @return TutorielChapitrePara
     */
    public function setParagraph($paragraph)
    {
        $this->paragraph = $paragraph;

        return $this;
    }

    /**
     * Get paragraph
     *
     * @return string 
     */
    public function getParagraph()
    {
        return $this->paragraph;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return TutorielChapitrePara
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
     * Set tutorielChapitre
     *
     * @param \FBN\GuideBundle\Entity\TutorielChapitre $tutorielChapitre
     * @return TutorielChapitrePara
     */
    public function setTutorielChapitre(\FBN\GuideBundle\Entity\TutorielChapitre $tutorielChapitre)
    {
        $this->tutorielChapitre = $tutorielChapitre;

        return $this;
    }

    /**
     * Get tutorielChapitre
     *
     * @return \FBN\GuideBundle\Entity\TutorielChapitre
     */
    public function getTutorielChapitre()
    {
        return $this->tutorielChapitre;
    }    

    /**
     * Set image
     *
     * @param \FBN\GuideBundle\Entity\Image $image
     * @return TutorielChapitrePara
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
