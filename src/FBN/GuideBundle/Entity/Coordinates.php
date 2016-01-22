<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Coordinates.
 *
 * @ORM\Table(name="coordinates")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordinatesRepository")
 */
class Coordinates
{
    /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesCountry")
   * @ORM\JoinColumn(nullable=false)
   */
  private $coordinatesCountry;

  /**
   * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesFR", inversedBy="coordinates", cascade={"persist"})
   * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
   */
  private $coordinatesFR;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Restaurant", mappedBy="coordinates")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $restaurant;

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
     * Set coordinatesFR.
     *
     * @param \FBN\GuideBundle\Entity\CoordinatesFR $coordinatesFR
     *
     * @return Coordinates
     */
    public function setCoordinatesFR(\FBN\GuideBundle\Entity\CoordinatesFR $coordinatesFR)
    {
        $this->coordinatesFR = $coordinatesFR;
        $coordinatesFR->setCoordinates($this);

        return $this;
    }

    /**
     * Get coordinatesFR.
     *
     * @return \FBN\GuideBundle\Entity\CoordinatesFR
     */
    public function getCoordinatesFR()
    {
        return $this->coordinatesFR;
    }

    /**
     * Set restaurant.
     *
     * @param \FBN\GuideBundle\Entity\Restaurant $restaurant
     *
     * @return Coordinates
     */
    public function setRestaurant(\FBN\GuideBundle\Entity\Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * Get restaurant.
     *
     * @return \FBN\GuideBundle\Entity\Restaurant
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        $country = $this->getCoordinatesCountry()->getCountry();
        $area = $this->getCoordinatesFR()->getCoordinatesFRDept()->getCoordinatesFRArea()->getArea();
        $dept = $this->getCoordinatesFR()->getCoordinatesFRDept()->getDepartment();
        $city = $this->getCoordinatesFR()->getCity();
        $lane = '';
        if (null !== $this->getCoordinatesFR()->getCoordinatesFRLane()) {
            $lane = $this->getCoordinatesFR()->getCoordinatesFRLane()->getLane();
        }
        $laneName = $this->getCoordinatesFR()->getLaneName();
        $laneNum = $this->getCoordinatesFR()->getLaneNum();
        $postCode = $this->getCoordinatesFR()->getPostcode();

        return $country.' / '.$area.' / '.$dept.' / '.$postCode.' / '.$city.' / '.$laneNum.', '.$lane.' '.$laneName;
    }
}
