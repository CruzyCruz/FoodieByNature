<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoordinatesFR.
 *
 * @ORM\Table(name="coordinates_fr")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordinatesFRRepository")
 */
class CoordinatesFR extends CoordinatesISO
{
    /**
    * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesFRLane")
    * @ORM\JoinColumn(nullable=true)
    */
   private $coordinatesFRLane;

   /**
    * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesFRCity")
    * @ORM\JoinColumn(nullable=false)
    */
   private $coordinatesFRCity;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Coordinates", mappedBy="coordinatesFR")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $coordinates;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="laneNum", type="string", length=255, nullable=true)
     */
    private $laneNum;

    /**
     * @var string
     *
     * @ORM\Column(name="laneName", type="string", length=255, nullable=true)
     */
    private $laneName;

    /**
     * @var string
     *
     * @ORM\Column(name="locality", type="string", length=255, nullable=true)
     */
    private $locality;

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
     * Set laneNum.
     *
     * @param string $laneNum
     *
     * @return CordonneesFR
     */
    public function setLaneNum($laneNum)
    {
        $this->laneNum = $laneNum;

        return $this;
    }

    /**
     * Get laneNum.
     *
     * @return string
     */
    public function getLaneNum()
    {
        return $this->laneNum;
    }

    /**
     * Set coordinatesFRLane.
     *
     * @param \FBN\GuideBundle\Entity\CoordinatesFRLane $coordinatesFRLane
     *
     * @return CoordinatesFR
     */
    public function setCoordinatesFRLane(\FBN\GuideBundle\Entity\CoordinatesFRLane $coordinatesFRLane)
    {
        $this->coordinatesFRLane = $coordinatesFRLane;

        return $this;
    }

    /**
     * Get coordinatesFRLane.
     *
     * @return \FBN\GuideBundle\Entity\CoordinatesFRLane
     */
    public function getCoordinatesFRLane()
    {
        return $this->coordinatesFRLane;
    }

    /**
     * Set coordinatesFRCity.
     *
     * @param \FBN\GuideBundle\Entity\CoordinatesFRCity $coordinatesFRCity
     *
     * @return CoordinatesFR
     */
    public function setCoordinatesFRCity(\FBN\GuideBundle\Entity\CoordinatesFRCity $coordinatesFRCity)
    {
        $this->coordinatesFRCity = $coordinatesFRCity;

        return $this;
    }

    /**
     * Get coordinatesFRCity.
     *
     * @return \FBN\GuideBundle\Entity\CoordinatesFRCity
     */
    public function getCoordinatesFRCity()
    {
        return $this->coordinatesFRCity;
    }

    /**
     * Set coordinates.
     *
     * @param \FBN\GuideBundle\Entity\Coordinates $coordinates
     *
     * @return CordinatesFR
     */
    public function setCoordinates(\FBN\GuideBundle\Entity\Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * Get coordinates.
     *
     * @return \FBN\GuideBundle\Entity\Coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set laneName.
     *
     * @param string $laneName
     *
     * @return CoordinatesFR
     */
    public function setLaneName($laneName)
    {
        $this->laneName = $laneName;

        return $this;
    }

    /**
     * Get laneName.
     *
     * @return string
     */
    public function getLaneName()
    {
        return $this->laneName;
    }

    /**
     * Set locality.
     *
     * @param string $locality
     *
     * @return Coordinates
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Get locality.
     *
     * @return string
     */
    public function getLocality()
    {
        return $this->locality;
    }
}
