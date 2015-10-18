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
     * @ORM\Column(name="paragraphe", type="text")
     * @Gedmo\Translatable          
     */
    private $paragraphe;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set paragraphe
     *
     * @param string $paragraphe
     * @return TutorielChapitrePara
     */
    public function setParagraphe($paragraphe)
    {
        $this->paragraphe = $paragraphe;

        return $this;
    }

    /**
     * Get paragraphe
     *
     * @return string 
     */
    public function getParagraphe()
    {
        return $this->paragraphe;
    }

    /**
     * Set rang
     *
     * @param integer $rang
     * @return TutorielChapitrePara
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
