<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bookmark.
 *
 * @ORM\Table(name="bookmark")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\BookmarkRepository")
 */
class Bookmark
{
    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Restaurant", inversedBy="bookmark")
     * @ORM\JoinColumn(nullable=true)
     */
    private $restaurant;

    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Winemaker", inversedBy="bookmark")
     * @ORM\JoinColumn(nullable=true)
     */
    private $winemaker;

    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Shop", inversedBy="bookmark")
     * @ORM\JoinColumn(nullable=true)
     */
    private $shop;

    /**
     * @ORM\ManyToOne(targetEntity="FBN\UserBundle\Entity\User", inversedBy="bookmark")
     * @ORM\JoinColumn(nullable=false)
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
    public function setRestaurant(\FBN\GuideBundle\Entity\Restaurant $restaurant = null)
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
    public function setWinemaker(\FBN\GuideBundle\Entity\Winemaker $winemaker = null)
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
     * Set shop.
     *
     * @param \FBN\GuideBundle\Entity\Shop $shop
     *
     * @return Shop
     */
    public function setShop(\FBN\GuideBundle\Entity\Shop $shop = null)
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
