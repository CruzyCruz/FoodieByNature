<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoordinatesFRArea.
 *
 * @ORM\Table(name="coordinatesfrarea")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordinatesFRAreaRepository")
 */
class CoordinatesFRArea
{
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
     * @ORM\Column(name="area", type="string", length=255)
     */
    private $area;

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
     * Set area.
     *
     * @param string $area
     *
     * @return CoordinatesFRArea
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area.
     *
     * @return string
     */
    public function getArea()
    {
        return $this->area;
    }
}
