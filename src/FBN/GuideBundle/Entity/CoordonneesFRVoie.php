<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoordonneesFRVoie
 *
 * @ORM\Table(name="coordonneesfrvoie")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordonneesFRVoieRepository")
 */
class CoordonneesFRVoie
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
     * @ORM\Column(name="lane", type="string", length=255, unique=true)
     */
    private $lane;


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
     * Set lane
     *
     * @param string $lane
     * @return CoordonneesFRVoie
     */
    public function setLane($lane)
    {
        $this->lane = $lane;

        return $this;
    }

    /**
     * Get lane
     *
     * @return string 
     */
    public function getLane()
    {
        return $this->lane;
    }
}
