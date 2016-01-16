<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Winemaker.
 *
 * @ORM\Table(name="winemaker")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\WinemakerRepository")
 */
class Winemaker extends Article
{
    /**
   * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\WinemakerDomain", mappedBy="winemaker")
   */
  private $winemakerDomain;

  /**
   * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\ImageWinemaker", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
  private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Gedmo\Slug(updatable=true, fields={"name"}, prefix="winemaker-")
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->winemakerDomain = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set slug.
     *
     * @param string $slug
     *
     * @return Winemaker
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
     * Set image.
     *
     * @param \FBN\GuideBundle\Entity\ImageWinemaker $image
     *
     * @return Winemaker
     */
    public function setImage(\FBN\GuideBundle\Entity\ImageWinemaker $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return \FBN\GuideBundle\Entity\ImageWinemaker
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add winemakerDomain.
     *
     * @param \FBN\GuideBundle\Entity\WinemakerDomain $winemakerDomain
     *
     * @return Winemaker
     */
    public function addWinemakerDomain(\FBN\GuideBundle\Entity\WinemakerDomain $winemakerDomain)
    {
        $this->winemakerDomain[] = $winemakerDomain;
        $winemakerDomain->setWinemaker($this);

        return $this;
    }

    /**
     * Remove winemakerDomain.
     *
     * @param \FBN\GuideBundle\Entity\WinemakerDomain $winemakerDomain
     */
    public function removeWinemakerDomain(\FBN\GuideBundle\Entity\WinemakerDomain $winemakerDomain)
    {
        $this->winemakerDomain->removeElement($winemakerDomain);
    }

    /**
     * Get winemakerDomain.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWinemakerDomain()
    {
        return $this->winemakerDomain;
    }
}
