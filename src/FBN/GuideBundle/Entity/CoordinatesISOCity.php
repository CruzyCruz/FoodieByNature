<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CoordinatesISOCity.
 *
 * @ORM\MappedSuperclass
 */
class CoordinatesISOCity
{
    /**
     * @var string
     *
     * @ORM\Column(name="postCode", type="integer")
     */
    protected $postCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(name="cityComplete", type="string", length=255)
     */
    private $cityComplete;

    /**
     * @var decimal
     *
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=6)
     * @Assert\Type(type="float")
     */
    private $latitude;

    /**
     * @var decimal
     *
     * @ORM\Column(name="longitude", type="decimal", precision=10, scale=6)
     * @Assert\Type(type="float")
     */
    private $longitude;

    /**
     * Set postCode.
     *
     * @param string $postCode
     *
     * @return CoordinatesFRCity
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Get postCode.
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set city.
     *
     * @param string $city
     *
     * @return CoordinatesFRCity
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set cityComplete.
     *
     * @param string $cityComplete
     *
     * @return CoordinatesFRCity
     */
    public function setCityComplete($cityComplete)
    {
        $this->cityComplete = $cityComplete;

        return $this;
    }

    /**
     * Get cityComplete.
     *
     * @return string
     */
    public function getCityComplete()
    {
        return $this->cityComplete;
    }

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
}
