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
    * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesFRLane")
    * @ORM\JoinColumn(nullable=true)
    */
   private $coordinatesFRLane;

   /**
    * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesFRCity")
    * @ORM\JoinColumn(nullable=false)
    * @Assert\NotBlank()
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

    public function __construct()
    {
        if (null !== $this->getCoordinates()) {
            $this->setCoordinatesCountry($this->getCoordinates()->getCoordinatesCountry());
        }
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
     * Set coordinatesFRLane.
     *
     * @param \FBN\GuideBundle\Entity\CoordinatesFRLane $coordinatesFRLane
     *
     * @return CoordinatesFR
     */
    public function setCoordinatesFRLane(\FBN\GuideBundle\Entity\CoordinatesFRLane $coordinatesFRLane = null)
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
    public function setCoordinatesFRCity(\FBN\GuideBundle\Entity\CoordinatesFRCity $coordinatesFRCity = null)
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
