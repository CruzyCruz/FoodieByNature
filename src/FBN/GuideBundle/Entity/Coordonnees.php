<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coordonnees
 *
 * @ORM\Table(name="coordonnees")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordonneesRepository")
 */
class Coordonnees
{
 
  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordonneesPays")
   * @ORM\JoinColumn(nullable=false)
   */
  private $coordonneesPays; 

  /**
   * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\CoordonneesFR", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
  private $coordonneesFR;  
   
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var decimal
     *
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=6)
     */
    private $latitude;

    /**
     * @var decimal
     *
     * @ORM\Column(name="longitude", type="decimal", precision=10, scale=6)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="metro", type="string", length=255, nullable=true)
     */
    private $metro;


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
     * Set latitude
     *
     * @param string $latitude
     * @return Coordonnees
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Coordonnees
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Coordonnees
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }   

    /**
     * Set metro
     *
     * @param string $metro
     * @return Coordonnees
     */
    public function setMetro($metro)
    {
        $this->metro = $metro;

        return $this;
    }

    /**
     * Get metro
     *
     * @return string 
     */
    public function getMetro()
    {
        return $this->metro;
    }

    /**
     * Set coordonneesPays
     *
     * @param \FBN\GuideBundle\Entity\CoordonneesPays $coordonneesPays
     * @return Coordonnees
     */
    public function setCoordonneesPays(\FBN\GuideBundle\Entity\CoordonneesPays $coordonneesPays)
    {
        $this->coordonneesPays = $coordonneesPays;

        return $this;
    }

    /**
     * Get coordonneesPays
     *
     * @return \FBN\GuideBundle\Entity\CoordonneesPays 
     */
    public function getCoordonneesPays()
    {
        return $this->coordonneesPays;
    }

    /**
     * Set coordonneesFR
     *
     * @param \FBN\GuideBundle\Entity\CoordonneesFR $coordonneesFR
     * @return Coordonnees
     */
    public function setCoordonneesFR(\FBN\GuideBundle\Entity\CoordonneesFR $coordonneesFR)
    {
        $this->coordonneesFR = $coordonneesFR;

        return $this;
    }

    /**
     * Get coordonneesFR
     *
     * @return \FBN\GuideBundle\Entity\CoordonneesFR 
     */
    public function getCoordonneesFR()
    {
        return $this->coordonneesFR;
    }

    /**
     * Set vigneron
     *
     * @param \FBN\GuideBundle\Entity\Vigneron $vigneron
     * @return Coordonnees
     */
    public function setVigneron(\FBN\GuideBundle\Entity\Vigneron $vigneron)
    {
        $this->vigneron = $vigneron;

        return $this;
    }

    /**
     * Get vigneron
     *
     * @return \FBN\GuideBundle\Entity\Vigneron 
     */
    public function getVigneron()
    {
        return $this->vigneron;
    }    
}
