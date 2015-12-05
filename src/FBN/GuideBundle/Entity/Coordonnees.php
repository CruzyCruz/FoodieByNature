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
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesCountry")
   * @ORM\JoinColumn(nullable=false)
   */
  private $coordinatesCountry; 

  /**
   * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesFR", cascade={"persist"})
   * @ORM\JoinColumn(nullable=false)
   */
  private $coordinatesFR;  
   
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
     * Set coordinatesCountry
     *
     * @param \FBN\GuideBundle\Entity\CoordinatesCountry $coordinatesCountry
     * @return Coordonnees
     */
    public function setCoordinatesCountry(\FBN\GuideBundle\Entity\CoordinatesCountry $coordinatesCountry)
    {
        $this->coordinatesCountry = $coordinatesCountry;

        return $this;
    }

    /**
     * Get coordinatesCountry
     *
     * @return \FBN\GuideBundle\Entity\CoordinatesCountry 
     */
    public function getCoordinatesCountry()
    {
        return $this->coordinatesCountry;
    }

    /**
     * Set coordinatesFR
     *
     * @param \FBN\GuideBundle\Entity\CoordinatesFR $coordinatesFR
     * @return Coordonnees
     */
    public function setCoordinatesFR(\FBN\GuideBundle\Entity\CoordinatesFR $coordinatesFR)
    {
        $this->coordinatesFR = $coordinatesFR;

        return $this;
    }

    /**
     * Get coordinatesFR
     *
     * @return \FBN\GuideBundle\Entity\CoordinatesFR 
     */
    public function getCoordinatesFR()
    {
        return $this->coordinatesFR;
    }

    /**
     * Set winemaker
     *
     * @param \FBN\GuideBundle\Entity\Winemaker $winemaker
     * @return Coordonnees
     */
    public function setWinemaker(\FBN\GuideBundle\Entity\Winemaker $winemaker)
    {
        $this->winemaker = $winemaker;

        return $this;
    }

    /**
     * Get winemaker
     *
     * @return \FBN\GuideBundle\Entity\Winemaker 
     */
    public function getWinemaker()
    {
        return $this->winemaker;
    }    
}
