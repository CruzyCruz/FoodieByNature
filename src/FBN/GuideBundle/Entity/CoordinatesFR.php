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
    * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesFRDept")
    * @ORM\JoinColumn(nullable=false)
    */
   private $coordinatesFRDept;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Coordinates", mappedBy="coordinatesFR")
     * @ORM\JoinColumn(nullable=true)
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
     * @ORM\Column(name="miscellaneous", type="string", length=255, nullable=true)
     */
    private $miscellaneous;

    /**
     * @var string
     *
     * @ORM\Column(name="locality", type="string", length=255, nullable=true)
     */
    private $locality;

    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=255)
     */
    private $postcode;

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
     * Set coordinatesFRDept.
     *
     * @param \FBN\GuideBundle\Entity\CoordinatesFRDept $coordinatesFRDept
     *
     * @return CoordinatesFR
     */
    public function setCoordinatesFRDept(\FBN\GuideBundle\Entity\CoordinatesFRDept $coordinatesFRDept)
    {
        $this->coordinatesFRDept = $coordinatesFRDept;

        return $this;
    }

    /**
     * Get coordinatesFRDept.
     *
     * @return \FBN\GuideBundle\Entity\CoordinatesFRDept
     */
    public function getCoordinatesFRDept()
    {
        return $this->coordinatesFRDept;
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
     * Set miscellaneous.
     *
     * @param string $miscellaneous
     *
     * @return Coordinates
     */
    public function setMiscellaneous($miscellaneous)
    {
        $this->miscellaneous = $miscellaneous;

        return $this;
    }

    /**
     * Get miscellaneous.
     *
     * @return string
     */
    public function getMiscellaneous()
    {
        return $this->miscellaneous;
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

    /**
     * Set postcode.
     *
     * @param string $postcode
     *
     * @return CoordinatesFR
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode.
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        $area = $this->getCoordinatesFRDept()->getCoordinatesFRArea()->getArea();
        $dept = $this->getCoordinatesFRDept()->getDepartment();
        $city = $this->getCity();
        $lane = '';
        if (null !== $this->getCoordinatesFRLane()) {
            $lane = $this->getCoordinatesFRLane()->getLane();
        }
        $laneName = $this->getLaneName();
        $laneNum = $this->getLaneNum();
        $postCode = $this->getPostcode();

        return $area.' / '.$dept.' / '.$postCode.' / '.$city.' / '.$laneNum.', '.$lane.' '.$laneName;
    }
}
