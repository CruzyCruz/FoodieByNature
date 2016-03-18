<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CoordinatesFRLane.
 *
 * @ORM\Table(name="coordinatesfrlane")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordinatesFRLaneRepository")
 * @UniqueEntity(fields="lane")
 */
class CoordinatesFRLane
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
     * @ORM\Column(name="lane", type="string", length=255, unique=true)
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $lane;

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
     * Set lane.
     *
     * @param string $lane
     *
     * @return CoordinatesFRLane
     */
    public function setLane($lane)
    {
        $this->lane = $lane;

        return $this;
    }

    /**
     * Get lane.
     *
     * @return string
     */
    public function getLane()
    {
        return $this->lane;
    }
}
