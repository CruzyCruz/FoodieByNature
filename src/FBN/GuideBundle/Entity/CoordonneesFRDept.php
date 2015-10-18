<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoordonneesFRDept
 *
 * @ORM\Table(name="coordonneesfrdept")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordonneesFRRegionRepository")
 */
class CoordonneesFRDept
{

  /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordonneesFRRegion")
   * @ORM\JoinColumn(nullable=false)
   */
  private $coordonneesFRRegion;

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
     * @ORM\Column(name="departement", type="string", length=255)
     */
    private $departement;

    /**
     * @var string
     *
     * @ORM\Column(name="num", type="string", length=255)
     */
    private $num;    

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
     * Set departement
     *
     * @param string $departement
     * @return CoordonneesFRRegionDept
     */
    public function setDepartement($departement)
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * Get departement
     *
     * @return string 
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * Set num
     *
     * @param string $num
     * @return CoordonneesFRRegionDept
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return string 
     */
    public function getNum()
    {
        return $this->num;
    }    

    /**
     * Set coordonneesFRRegion
     *
     * @param \FBN\GuideBundle\Entity\coordonneesFRRegion $coordonneesFRRegion
     * @return Restaurant
     */
    public function setCoordonneesFRRegion(\FBN\GuideBundle\Entity\coordonneesFRRegion $coordonneesFRRegion)
    {
        $this->coordonneesFRRegion = $coordonneesFRRegion;

        return $this;
    }

    /**
     * Get coordonneesFRRegion
     *
     * @return \FBN\GuideBundle\Entity\coordonneesFRRegion 
     */
    public function getCoordonneesFRRegion()
    {
        return $this->coordonneesFRRegion;
    }    
}
