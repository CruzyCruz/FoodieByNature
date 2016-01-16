<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Tutorial.
 *
 * @ORM\Table(name="tutorial")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\TutorialRepository")
 */
class Tutorial extends Article
{
    /**
   * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\TutorialChapter", mappedBy="tutorial")
   * @ORM\OrderBy({"rank" = "ASC"})
   */
  private $tutorialChapter;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\ImageTutorial", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\TutorialSection", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tutorialSection;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="rank", type="integer")
     */
    private $rank;

    /**
     * @var string
     *
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    /**
     * @Gedmo\Slug(updatable=true, fields={"name"}, prefix="tutorial-")
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->TutorialChapter = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set rank.
     *
     * @param int $rank
     *
     * @return Tutorial
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank.
     *
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Tutorial
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set image.
     *
     * @param \FBN\GuideBundle\Entity\ImageTutorial $image
     *
     * @return Tutorial
     */
    public function setImage(\FBN\GuideBundle\Entity\ImageTutorial $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return \FBN\GuideBundle\Entity\ImageTutorial
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set tutorialSection.
     *
     * @param \FBN\GuideBundle\Entity\RestaurantPrice $tutorialSection
     *
     * @return Restaurant
     */
    public function setTutorialSection(\FBN\GuideBundle\Entity\TutorialSection $tutorialSection)
    {
        $this->tutorialSection = $tutorialSection;

        return $this;
    }

    /**
     * Get tutorialSection.
     *
     * @return \FBN\GuideBundle\Entity\TutorialSection
     */
    public function getTutorialSection()
    {
        return $this->tutorialSection;
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
     * Add tutorialChapter.
     *
     * @param \FBN\GuideBundle\Entity\TutorialChapter $tutorialChapter
     *
     * @return Tutorial
     */
    public function addTutorialChapter(\FBN\GuideBundle\Entity\TutorialChapter $tutorialChapter)
    {
        $this->tutorialChapter[] = $tutorialChapter;
        $tutorialChapter->setTutorial($this);

        return $this;
    }

    /**
     * Remove tutorialChapter.
     *
     * @param \FBN\GuideBundle\Entity\TutorialChapter $tutorialChapter
     */
    public function removeTutorialChapter(\FBN\GuideBundle\Entity\TutorialChapter $tutorialChapter)
    {
        $this->tutorialChapter->removeElement($tutorialChapter);
    }

    /**
     * Get tutorialChapter.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTutorialChapter()
    {
        return $this->tutorialChapter;
    }
}
