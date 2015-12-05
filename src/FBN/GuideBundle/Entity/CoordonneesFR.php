<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoordonneesFR
 *
 * @ORM\Table(name="coordonneesfr")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordonneesFRRepository")
 */
class CoordonneesFR
{

   /**
    * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordonneesFRVoie")
    * @ORM\JoinColumn(nullable=true)
    */
   private $coordonneesFRVoie;

   /**
    * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesFRDept")
    * @ORM\JoinColumn(nullable=false)
    */
   private $coordinatesFRDept;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set laneNum
     *
     * @param string $laneNum
     * @return CordonneesFR
     */
    public function setLaneNum($laneNum)
    {
        $this->laneNum = $laneNum;

        return $this;
    }

    /**
     * Get laneNum
     *
     * @return string 
     */
    public function getLaneNum()
    {
        return $this->laneNum;
    }

    /**
     * Set coordonneesFRVoie
     *
     * @param \FBN\GuideBundle\Entity\CoordonneesFRVoie $coordonneesFRVoie
     * @return CoordonneesFR
     */
    public function setCoordonneesFRVoie(\FBN\GuideBundle\Entity\CoordonneesFRVoie $coordonneesFRVoie)
    {
        $this->coordonneesFRVoie = $coordonneesFRVoie;

        return $this;
    }

    /**
     * Get coordonneesFRVoie
     *
     * @return \FBN\GuideBundle\Entity\CoordonneesFRVoie 
     */
    public function getCoordonneesFRVoie()
    {
        return $this->coordonneesFRVoie;
    }

    /**
     * Set coordinatesFRDept
     *
     * @param \FBN\GuideBundle\Entity\CoordinatesFRDept $coordinatesFRDept
     * @return CoordonneesFR
     */
    public function setCoordinatesFRDept(\FBN\GuideBundle\Entity\CoordinatesFRDept $coordinatesFRDept)
    {
        $this->coordinatesFRDept = $coordinatesFRDept;

        return $this;
    }

    /**
     * Get coordinatesFRDept
     *
     * @return \FBN\GuideBundle\Entity\CoordinatesFRDept 
     */
    public function getCoordinatesFRDept()
    {
        return $this->coordinatesFRDept;
    }

    /**
     * Set laneName
     *
     * @param string $laneName
     * @return CoordonneesFR
     */
    public function setLaneName($laneName)
    {
        $this->laneName = $laneName;

        return $this;
    }

    /**
     * Get laneName
     *
     * @return string 
     */
    public function getLaneName()
    {
        return $this->laneName;
    }

    /**
     * Set miscellaneous
     *
     * @param string $miscellaneous
     * @return Coordonnees
     */
    public function setMiscellaneous($miscellaneous)
    {
        $this->miscellaneous = $miscellaneous;

        return $this;
    }

    /**
     * Get miscellaneous
     *
     * @return string 
     */
    public function getMiscellaneous()
    {
        return $this->miscellaneous;
    }     

    /**
     * Set locality
     *
     * @param string $locality
     * @return Coordonnees
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Get locality
     *
     * @return string 
     */
    public function getLocality()
    {
        return $this->locality;
    } 

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return CoordonneesFR
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string 
     */
    public function getPostcode()
    {
        return $this->postcode;
    }
}
