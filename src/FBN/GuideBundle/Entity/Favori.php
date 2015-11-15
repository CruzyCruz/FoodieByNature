<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favori.
 *
 * @ORM\Table(name="favori")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\FavoriRepository")
 */
class Favori
{
    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Restaurant")
     * @ORM\JoinColumn(nullable=true)
     */
    private $restaurant;

    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Winemaker")
     * @ORM\JoinColumn(nullable=true)
     */
    private $winemaker;

    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Caviste")
     * @ORM\JoinColumn(nullable=true)
     */
    private $caviste;

    /**
     * @ORM\ManyToOne(targetEntity="FBN\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

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
     * Set restaurant.
     *
     * @param \FBN\GuideBundle\Entity\Restaurant $restaurant
     *
     * @return Restaurant
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
     * Set winemaker.
     *
     * @param \FBN\GuideBundle\Entity\Winemaker $winemaker
     *
     * @return Winemaker
     */
    public function setWinemaker(\FBN\GuideBundle\Entity\Winemaker $winemaker)
    {
        $this->winemaker = $winemaker;

        return $this;
    }

    /**
     * Get winemaker.
     *
     * @return \FBN\GuideBundle\Entity\Winemaker
     */
    public function getWinemaker()
    {
        return $this->winemaker;
    }

    /**
     * Set caviste.
     *
     * @param \FBN\GuideBundle\Entity\Caviste $caviste
     *
     * @return Caviste
     */
    public function setCaviste(\FBN\GuideBundle\Entity\Caviste $caviste)
    {
        $this->caviste = $caviste;

        return $this;
    }

    /**
     * Get caviste.
     *
     * @return \FBN\GuideBundle\Entity\Caviste
     */
    public function getCaviste()
    {
        return $this->caviste;
    }

    /**
     * Set user.
     *
     * @param \FBN\GuideBundle\Entity\User $user
     *
     * @return user
     */
    public function setUser(\FBN\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \FBN\GuideBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
