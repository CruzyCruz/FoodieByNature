<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoordinatesCountry.
 *
 * @ORM\Table(name="coordinatescountry")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordinatesCountryRepository")
 */
class CoordinatesCountry
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
     * @ORM\Column(name="country", type="string", length=255, unique=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="codeISO", type="string", length=255, unique=true)
     */
    private $codeISO;

    /**
     * @var decimal
     *
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=6, unique=true)
     */
    private $latitude;

    /**
     * @var decimal
     *
     * @ORM\Column(name="longitude", type="decimal", precision=10, scale=6, unique=true)
     */
    private $longitude;

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
     * Set country.
     *
     * @param string $country
     *
     * @return CoordinatesCountry
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country.
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set codeISO.
     *
     * @param string $codeISO
     *
     * @return CoordinatesCountry
     */
    public function setCodeISO($codeISO)
    {
        $this->codeISO = $codeISO;

        return $this;
    }

    /**
     * Get codeISO.
     *
     * @return string
     */
    public function getCodeISO()
    {
        return $this->codeISO;
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

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getCountry();
    }
}
