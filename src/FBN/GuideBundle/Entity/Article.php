<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FBN\UserBundle\Entity\User;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article.
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Article
{
    const NUM_KIND_OF_ARTICLES = 6;
    const NUM_ITEMS = 8;
    const NUM_ITEMS_HOMEPAGE = 4;

    /**
     * Property overridden in child class.
     *
     * @var FBN\UserBundle\Entity\User
     */
    protected $articleOwner;

    /**
     * @var FBN\UserBundle\Entity\User
     *
     * @Gedmo\Blameable(on="update")
     * @ORM\ManyToOne(targetEntity="FBN\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    protected $articleUpdater;

    /**
     * @var string
     *
     * @ORM\Column(name="articleAuthor", type="string", length=255)
     */
    private $articleAuthor;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Gedmo\Translatable
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Gedmo\Translatable
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="dateModification", type="datetime")
     */
    private $dateModification;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="change", field={"publication"})
     * @ORM\Column(name="datePublication", type="datetime")
     */
    private $datePublication;

    /**
     * @var bool
     *
     * @ORM\Column(name="publication", type="boolean")
     */
    private $publication;

    /**
     * @var string
     *
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    protected $locale;

    public function __construct()
    {
        $this->datePublication = new \DateTime();
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Article
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set articleOwner.
     *
     * @param FBN\UserBundle\Entity\User $articleOwner
     *
     * @return Article
     */
    public function setArticleOwner($articleOwner)
    {
        $this->articleOwner = $articleOwner;

        return $this;
    }

    /**
     * Get articleOwner.
     *
     * @return FBN\UserBundle\Entity\User
     */
    public function getArticleOwner()
    {
        return $this->articleOwner;
    }

    /**
     * Get articleUpdater.
     *
     * @return FBN\UserBundle\Entity\User
     */
    public function getArticleUpdater()
    {
        return $this->articleUpdater;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Article
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return Article
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation.
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateModification.
     *
     * @param \DateTime $dateModification
     *
     * @return Article
     */
    public function setDateModification($dateModification)
    {
        $this->dateModification = $dateModification;

        return $this;
    }

    /**
     * Get dateModification.
     *
     * @return \DateTime
     */
    public function getDateModification()
    {
        return $this->dateModification;
    }

    /**
     * Set datePublication.
     *
     * @param \DateTime $datePublication
     *
     * @return Article
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication.
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set publication.
     *
     * @param bool $publication
     *
     * @return Article
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication.
     *
     * @return bool
     */
    public function getPublication()
    {
        return $this->publication;
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

    /**
     * Set articleAuthor.
     *
     * @param string $articleAuthor
     *
     * @return Article
     */
    public function setArticleAuthor($articleAuthor)
    {
        $this->articleAuthor = $articleAuthor;

        return $this;
    }

    /**
     * Get articleAuthor.
     *
     * @return string
     */
    public function getArticleAuthor()
    {
        return $this->articleAuthor;
    }

    /**
     * Set articleAuthor on PreFlush.
     *
     * Article vs User : an article has an owner (the one who created the article). Then, only the owner (ROLE_AUTHOR at least)
     * or an user with ROLE_ADMIN can modify this article.
     * This lifecycle event ensures that the field articleAuthor is never null and related to the owner.
     * Nota : if the owner is deleted (by an admin), then only a user with ROLE_ADMIN can update this article. Later, an admin can
     * set a new owner in charge of this article. Between initial owner deletion and new owner setting, the article author (author name)
     * remains the one of the initial owner.
     *
     * @ORM\PreFlush
     */
    public function setArticleAuthorOnPreFlush()
    {
        if (null !== $this->articleOwner) {
            $this->articleAuthor = $this->articleOwner->getAuthorName();
        }
    }

    /**
     * Get class name.
     *
     * @return string
     */
    public function getClass()
    {
        $classInfo = new \ReflectionClass($this);

        return $classInfo->getShortName();
    }

    public function findArticleOwner()
    {
        return null === $this->getArticleOwner() ? User::NO_OWNER : $this->getArticleOwner();
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getName().' / ['.$this->findArticleOwner().']';
    }
}
