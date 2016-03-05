<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoordinatesISO.
 *
 * @ORM\MappedSuperclass
 */
class CoordinatesISO
{
    /**
     * @var decimal
     *
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=6)
     */
    private $latitude;

    /**
     * @var decimal
     *
     * @ORM\Column(name="longitude", type="decimal", precision=10, scale=6)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="miscellaneous", type="string", length=255, nullable=true)
     */
    private $miscellaneous;

    /**
     * @var string
     *
     * @ORM\Column(name="metro", type="string", length=255, nullable=true)
     */
    private $metro;

    /**
     * Set latitude.
     *
     * @param string $latitude
     *
     * @return Coordinates
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude.
     *
     * @param string $longitude
     *
     * @return Coordinates
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
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
     * Set metro.
     *
     * @param string $metro
     *
     * @return Coordinates
     */
    public function setMetro($metro)
    {
        $this->metro = $metro;

        return $this;
    }

    /**
     * Get metro.
     *
     * @return string
     */
    public function getMetro()
    {
        return $this->metro;
    }
}
