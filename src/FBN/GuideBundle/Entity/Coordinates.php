<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Coordinates.
 *
 * @ORM\Table(name="coordinates")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordinatesRepository")
 */
class Coordinates
{
    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesCountry")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $coordinatesCountry;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\CoordinatesFR", inversedBy="coordinates", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Assert\Valid()
     */
    private $coordinatesFR;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Restaurant", mappedBy="coordinates")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $restaurant;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\WinemakerDomain", mappedBy="coordinates")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $winemakerDomain;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Shop", mappedBy="coordinates")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $shop;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Event", mappedBy="coordinates")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $event;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
     * Set coordinatesCountry.
     *
     * @param \FBN\GuideBundle\Entity\CoordinatesCountry $coordinatesCountry
     *
     * @return Coordinates
     */
    public function setCoordinatesCountry(\FBN\GuideBundle\Entity\CoordinatesCountry $coordinatesCountry)
    {
        $this->coordinatesCountry = $coordinatesCountry;

        return $this;
    }

    /**
     * Get coordinatesCountry.
     *
     * @return \FBN\GuideBundle\Entity\CoordinatesCountry
     */
    public function getCoordinatesCountry()
    {
        return $this->coordinatesCountry;
    }

    /**
     * Set coordinatesFR.
     *
     * @param \FBN\GuideBundle\Entity\CoordinatesFR $coordinatesFR
     *
     * @return Coordinates
     */
    public function setCoordinatesFR(\FBN\GuideBundle\Entity\CoordinatesFR $coordinatesFR = null)
    {
        $this->coordinatesFR = $coordinatesFR;
        $coordinatesFR->setCoordinates($this);

        return $this;
    }

    /**
     * Get coordinatesFR.
     *
     * @return \FBN\GuideBundle\Entity\CoordinatesFR
     */
    public function getCoordinatesFR()
    {
        return $this->coordinatesFR;
    }

    /**
     * Set restaurant.
     *
     * @param \FBN\GuideBundle\Entity\Restaurant $restaurant
     *
     * @return Coordinates
     */
    public function setRestaurant(\FBN\GuideBundle\Entity\Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * Get restaurant.
     *
     * @return \FBN\GuideBundle\Entity\Restaurant
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * Set winemakerDomain.
     *
     * @param \FBN\GuideBundle\Entity\Restaurant $winemakerDomain
     *
     * @return Coordinates
     */
    public function setWinemakerDomain(\FBN\GuideBundle\Entity\WinemakerDomain $winemakerDomain)
    {
        $this->winemakerDomain = $winemakerDomain;

        return $this;
    }

    /**
     * Get winemakerDomain.
     *
     * @return \FBN\GuideBundle\Entity\WinemakerDomain
     */
    public function getWinemakerDomain()
    {
        return $this->winemakerDomain;
    }

    /**
     * Set shop.
     *
     * @param \FBN\GuideBundle\Entity\Shop $shop
     *
     * @return Coordinates
     */
    public function setShop(\FBN\GuideBundle\Entity\Shop $shop)
    {
        $this->shop = $shop;

        return $this;
    }

    /**
     * Get shop.
     *
     * @return \FBN\GuideBundle\Entity\Shop
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * Set event.
     *
     * @param \FBN\GuideBundle\Entity\Event $event
     *
     * @return Coordinates
     */
    public function setEvent(\FBN\GuideBundle\Entity\Event $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event.
     *
     * @return \FBN\GuideBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        $country = $this->getCoordinatesCountry()->getCountry();
        $codeISO = $this->getCoordinatesCountry()->getCodeISO();
        $getCoordinatesISO = 'getCoordinates'.$codeISO;
        $getCoordinatesISOCity = 'getCoordinates'.$codeISO.'City';

        return $country.' / '.$this->$getCoordinatesISO()->$getCoordinatesISOCity()->getCity();
    }
}
