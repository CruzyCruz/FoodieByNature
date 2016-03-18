<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CoordinatesFR.
 *
 * @ORM\Table(name="coordinates_fr")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordinatesFRRepository")
 */
class CoordinatesFR extends CoordinatesISO
{
    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesCountry")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $coordinatesCountry;

   /**
    * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesFRLane")
    * @ORM\JoinColumn(nullable=true)
    */
   private $coordinatesFRLane;

   /**
    * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesFRCity")
    * @ORM\JoinColumn(nullable=false)
    * @Assert\NotNull()
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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set coordinatesCountry.
     *
     * @param \FBN\GuideBundle\Entity\CoordinatesCountry $coordinatesCountry
     *
     * @return Coordinates
     */
    public function setCoordinatesCountry(\FBN\GuideBundle\Entity\CoordinatesCountry $coordinatesCountry)
    {
        $this->coordinatesCountry = $coordinatesCountry;

        return $this;
    }

    /**
     * Get coordinatesCountry.
     *
     * @return \FBN\GuideBundle\Entity\CoordinatesCountry
     */
    public function getCoordinatesCountry()
    {
        return $this->coordinatesCountry;
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
}
