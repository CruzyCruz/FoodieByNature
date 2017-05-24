<?php

namespace FBN\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User.
 *
 * @ORM\Table(name="fbn_user")
 * @ORM\Entity(repositoryClass="FBN\UserBundle\Entity\UserRepository")
 * @UniqueEntity("authorName", groups={"Registration", "Profile"})
 */
class User extends BaseUser
{
    /**
     * @var string
     *
     * String used to identify an article wich has no owner
     */
    const NO_OWNER = 'NO OWNER';

    /**
     * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\Restaurant", mappedBy="articleOwner")
     */
    private $restaurants;

    /**
     * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\Shop", mappedBy="articleOwner")
     */
    private $shops;

    /**
     * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\Info", mappedBy="articleOwner")
     */
    private $infos;

    /**
     * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\Winemaker", mappedBy="articleOwner")
     */
    private $winemakers;

    /**
     * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\Event", mappedBy="articleOwner")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\Tutorial", mappedBy="articleOwner")
     */
    private $tutorials;

    /**
     * Inversed relationship only used for user bookmarks deletion on user deletion.
     *
     * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\Bookmark", mappedBy="user", cascade={"remove"})
     */
    private $bookmark;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="googleid", type="string", nullable=true)
     */
    private $googleId;

    /**
     * @var string
     *
     * @ORM\Column(name="facebookid", type="string", nullable=true)
     */
    private $facebookId;

    /**
     * @var string
     *
     * @ORM\Column(name="authorName", type="string", length=255, nullable=true, unique=true)
     * @Assert\Length(min = 4, groups={"Registration", "Profile"})
     */
    private $authorName;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->restaurants = new ArrayCollection();
        $this->shops = new ArrayCollection();
        $this->infos = new ArrayCollection();
        $this->winemakers = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->tutorials = new ArrayCollection();
    }

    /**
     * Set googleId.
     *
     * @param string $googleId
     *
     * @return User
     */
    public function setGoogleId($googleId = null)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId.
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set facebookId.
     *
     * @param string $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId = null)
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId.
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set authorName.
     *
     * @param string $authorName
     *
     * @return Article
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * Get authorName.
     *
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Add restaurant.
     *
     * @param \FBN\GuideBundle\Entity\Restaurant $restaurant
     *
     * @return User
     */
    public function addRestaurant(\FBN\GuideBundle\Entity\Restaurant $restaurant)
    {
        $this->restaurants[] = $restaurant;
        $restaurant->setArticleOwner($this);

        return $this;
    }

    /**
     * Remove restaurant.
     *
     * @param \FBN\GuideBundle\Entity\Restaurant $restaurant
     */
    public function removeRestaurant(\FBN\GuideBundle\Entity\Restaurant $restaurant)
    {
        $this->restaurants->removeElement($restaurant);
        $restaurant->setArticleOwner(null);
    }

    /**
     * Get restaurants.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRestaurants()
    {
        return $this->restaurants;
    }

    /**
     * Add shop.
     *
     * @param \FBN\GuideBundle\Entity\Shop $shop
     *
     * @return User
     */
    public function addShop(\FBN\GuideBundle\Entity\Shop $shop)
    {
        $this->shops[] = $shop;
        $shop->setArticleOwner($this);

        return $this;
    }

    /**
     * Remove shop.
     *
     * @param \FBN\GuideBundle\Entity\Shop $shop
     */
    public function removeShop(\FBN\GuideBundle\Entity\Shop $shop)
    {
        $this->shops->removeElement($shop);
        $shop->setArticleOwner(null);
    }

    /**
     * Get shops.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShops()
    {
        return $this->shops;
    }

    /**
     * Add info.
     *
     * @param \FBN\GuideBundle\Entity\Info $info
     *
     * @return User
     */
    public function addInfo(\FBN\GuideBundle\Entity\Info $info)
    {
        $this->infos[] = $info;
        $info->setArticleOwner($this);

        return $this;
    }

    /**
     * Remove info.
     *
     * @param \FBN\GuideBundle\Entity\Info $info
     */
    public function removeInfo(\FBN\GuideBundle\Entity\Info $info)
    {
        $this->infos->removeElement($info);
        $info->setArticleOwner(null);
    }

    /**
     * Get infos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInfos()
    {
        return $this->infos;
    }

    /**
     * Add winemaker.
     *
     * @param \FBN\GuideBundle\Entity\Winemaker $winemaker
     *
     * @return User
     */
    public function addWinemaker(\FBN\GuideBundle\Entity\Winemaker $winemaker)
    {
        $this->winemakers[] = $winemaker;
        $winemaker->setArticleOwner($this);

        return $this;
    }

    /**
     * Remove winemaker.
     *
     * @param \FBN\GuideBundle\Entity\Winemaker $winemaker
     */
    public function removeWinemaker(\FBN\GuideBundle\Entity\Winemaker $winemaker)
    {
        $this->winemakers->removeElement($winemaker);
        $winemaker->setArticleOwner(null);
    }

    /**
     * Get winemakers.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWinemakers()
    {
        return $this->winemakers;
    }

    /**
     * Add event.
     *
     * @param \FBN\GuideBundle\Entity\Event $event
     *
     * @return User
     */
    public function addEvent(\FBN\GuideBundle\Entity\Event $event)
    {
        $this->events[] = $event;
        $event->setArticleOwner($this);

        return $this;
    }

    /**
     * Remove event.
     *
     * @param \FBN\GuideBundle\Entity\Event $event
     */
    public function removeEvent(\FBN\GuideBundle\Entity\Event $event)
    {
        $this->events->removeElement($event);
        $event->setArticleOwner(null);
    }

    /**
     * Get events.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add tutorial.
     *
     * @param \FBN\GuideBundle\Entity\Tutorial $tutorial
     *
     * @return User
     */
    public function addTutorial(\FBN\GuideBundle\Entity\Tutorial $tutorial)
    {
        $this->tutorials[] = $tutorial;
        $tutorial->setArticleOwner($this);

        return $this;
    }

    /**
     * Remove tutorial.
     *
     * @param \FBN\GuideBundle\Entity\Tutorial $tutorial
     */
    public function removeTutorial(\FBN\GuideBundle\Entity\Tutorial $tutorial)
    {
        $this->tutorials->removeElement($tutorial);
        $tutorial->setArticleOwner(null);
    }

    /**
     * Get events.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTutorials()
    {
        return $this->tutorials;
    }

    /**
     * Ensure that an user can not choose as user name the same string as the one defined by NO_OWNER constant.
     *
     * @Assert\IsTrue(message = "fbn.user.admin.user.isUserNameValid", groups={"Registration", "Profile"}).
     */
    public function isUserNameValid()
    {
        return $this->username !== self::NO_OWNER;
    }

    /**
     * Ensure that an user with ROLE_AUTHOR or ROLE_ADMIN has an author name.
     *
     * @Assert\IsTrue(message = "fbn.user.admin.user.isAuthorNameNeeded", groups={"Registration", "Profile"}).
     */
    public function isAuthorNameNeeded()
    {
        return !((in_array('ROLE_AUTHOR', $this->roles, true) || in_array('ROLE_ADMIN', $this->roles, true)) && (null === $this->authorName));
    }
}
