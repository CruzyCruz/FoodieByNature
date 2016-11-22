<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TutorialChapter.
 *
 * @ORM\Table(name="tutorial_chapter")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\TutorialChapterRepository")
 */
class TutorialChapter
{
    /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Tutorial", inversedBy="tutorialChapter")
   * @ORM\JoinColumn(nullable=false)
   */
  private $tutorial;

  /**
   * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\TutorialChapterPara", mappedBy="tutorialChapter", cascade={"persist","remove"}, orphanRemoval=true)
   * @ORM\OrderBy({"rank" = "ASC"})
   * @Assert\Valid()
   */
  private $tutorialChapterParas;

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
     * @ORM\Column(name="title", type="string", length=255)
     * @Gedmo\Translatable
     * @Assert\NotBlank()         
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="rank", type="integer")
     */
    private $rank;

    /**
     * @Gedmo\Slug(updatable=true, unique=false, fields={"rank"}, prefix="-chapter-")
     * @ORM\Column(length=128)
     */
    private $slug;

    /**
     * @var string
     *
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->tutorialChapterParas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title.
     *
     * @param string $title
     *
     * @return Chapitre
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set rank.
     *
     * @param int $rank
     *
     * @return TutorialChapter
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
     * @return TutorialChapter
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
     * Set tutorial.
     *
     * @param \FBN\GuideBundle\Entity\Tutorial $tutorial
     *
     * @return TutorialChapter
     */
    public function setTutorial(\FBN\GuideBundle\Entity\Tutorial $tutorial)
    {
        $this->tutorial = $tutorial;

        return $this;
    }

    /**
     * Get tutorial.
     *
     * @return \FBN\GuideBundle\Entity\Tutorial
     */
    public function getTutorial()
    {
        return $this->tutorial;
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
     * Add tutorialChapterPara.
     *
     * @param \FBN\GuideBundle\Entity\TutorialChapterPara $tutorialChapterPara
     *
     * @return TutorialChapter
     */
    public function addTutorialChapterPara(\FBN\GuideBundle\Entity\TutorialChapterPara $tutorialChapterPara)
    {
        $this->tutorialChapterParas[] = $tutorialChapterPara;
        $tutorialChapterPara->setTutorialChapter($this);

        return $this;
    }

    /**
     * Remove tutorialChapterPara.
     *
     * @param \FBN\GuideBundle\Entity\TutorialChapterPara $tutorialChapterPara
     */
    public function removeTutorialChapterPara(\FBN\GuideBundle\Entity\TutorialChapterPara $tutorialChapterPara)
    {
        $this->tutorialChapterParas->removeElement($tutorialChapterPara);
    }

    /**
     * Get tutorialChapterParas.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTutorialChapterParas()
    {
        return $this->tutorialChapterParas;
    }
}
