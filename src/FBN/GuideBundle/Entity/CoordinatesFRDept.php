<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoordinatesFRDept.
 *
 * @ORM\Table(name="coordinatesfrdept")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordinatesFRAreaRepository")
 */
class CoordinatesFRDept
{
    /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesFRArea")
   * @ORM\JoinColumn(nullable=false)
   */
  private $coordinatesFRArea;

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
     * @ORM\Column(name="department", type="string", length=255, unique=true)
     */
    private $department;

    /**
     * @var string
     *
     * @ORM\Column(name="num", type="string", length=255)
     */
    private $num;

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
     * Set department.
     *
     * @param string $department
     *
     * @return CoordinatesFRAreaDept
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department.
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set num.
     *
     * @param string $num
     *
     * @return CoordinatesFRAreaDept
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num.
     *
     * @return string
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set coordinatesFRArea.
     *
     * @param \FBN\GuideBundle\Entity\coordinatesFRArea $coordinatesFRArea
     *
     * @return Restaurant
     */
    public function setCoordinatesFRArea(\FBN\GuideBundle\Entity\coordinatesFRArea $coordinatesFRArea)
    {
        $this->coordinatesFRArea = $coordinatesFRArea;

        return $this;
    }

    /**
     * Get coordinatesFRArea.
     *
     * @return \FBN\GuideBundle\Entity\coordinatesFRArea
     */
    public function getCoordinatesFRArea()
    {
        return $this->coordinatesFRArea;
    }
}
