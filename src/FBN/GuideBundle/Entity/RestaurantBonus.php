<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RestaurantBonus.
 *
 * @ORM\Table(name="restaurant_bonus")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\RestaurantBonusRepository")
 * @UniqueEntity(fields="bonus")
 */
class RestaurantBonus
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
     * @ORM\Column(name="bonus", type="string", length=255, unique=true)
     * @Gedmo\Translatable
     * @Assert\NotBlank()
     */
    private $bonus;

    /**
     * @var string
     *
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

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
     * Set bonus.
     *
     * @param string $bonus
     *
     * @return RestaurantBonus
     */
    public function setBonus($bonus)
    {
        $this->bonus = $bonus;

        return $this;
    }

    /**
     * Get bonus.
     *
     * @return string
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * Set locale.
     *
     * @param string $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getBonus();
    }
}
