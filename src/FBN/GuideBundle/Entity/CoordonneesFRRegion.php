<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoordonneesFRRegion
 *
 * @ORM\Table(name="coordonneesfrregion")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordonneesFRRegionRepository")
 */
class CoordonneesFRRegion
{
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
     * @ORM\Column(name="area", type="string", length=255)
     */
    private $area;


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
     * Set area
     *
     * @param string $area
     * @return CoordonneesFRRegion
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return string 
     */
    public function getArea()
    {
        return $this->area;
    }
}
