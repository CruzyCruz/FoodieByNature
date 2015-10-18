<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Vigneron
 *
 * @ORM\Table(name="vigneron")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\VigneronRepository")
 */
class Vigneron extends Article
{

  /**
   * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\VigneronDomaine", mappedBy="vigneron")
   */
  private $vigneronDomaine;   

  /**
   * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Image", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
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
     * @Gedmo\Slug(fields={"nom"}, prefix="vigneron-")
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;      

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(); 
        $this->vigneronDomaine = new \Doctrine\Common\Collections\ArrayCollection();

    }

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
     * Set slug
     *
     * @param string $slug
     * @return Vigneron
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
     * @return Vigneron
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
     * Add vigneronDomaine
     *
     * @param \FBN\GuideBundle\Entity\VigneronDomaine $vigneronDomaine
     * @return Vigneron
     */
    public function addVigneronDomaine(\FBN\GuideBundle\Entity\VigneronDomaine $vigneronDomaine)
    {
        $this->vigneronDomaine[] = $vigneronDomaine;
        $vigneronDomaine->setVigneron($this); 

        return $this;
    }

    /**
     * Remove vigneronDomaine
     *
     * @param \FBN\GuideBundle\Entity\VigneronDomaine $vigneronDomaine
     */
    public function removeVigneronDomaine(\FBN\GuideBundle\Entity\VigneronDomaine $vigneronDomaine)
    {
        $this->vigneronDomaine->removeElement($vigneronDomaine);
    }

    /**
     * Get vigneronDomaine
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVigneronDomaine()
    {
        return $this->vigneronDomaine;
    }
}
