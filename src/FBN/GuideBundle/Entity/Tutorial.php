<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tutorial.
 *
 * @ORM\Table(name="tutorial")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\TutorialRepository")
 */
class Tutorial extends Article
{
    /**
   * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\TutorialChapter", mappedBy="tutorial", cascade={"persist","remove"}, orphanRemoval=true)
   * @ORM\OrderBy({"rank" = "ASC"})
   * 
   * @Assert\Valid()
   */
  private $tutorialChapter;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\ImageTutorial", inversedBy="tutorial", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\TutorialSection")
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
     * @Gedmo\Translatable
     * @Gedmo\Slug(updatable=true, fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->tutorialChapter = new \Doctrine\Common\Collections\ArrayCollection();
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
        $image->setTutorial($this);

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

    /**
     * @Assert\IsTrue(message = "fbn.guide.admin.tutorial.isTutorialChapterCollectionNotEmpty").
     */
    public function isTutorialChapterCollectionNotEmpty()
    {
        if ($this->tutorialChapter->isEmpty()) {
            return false;
        }

        return true;
    }
}
