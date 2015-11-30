<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * TutorialChapter.
 *
 * @ORM\Table(name="tutorialchapter")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\TutorialChapterRepository")
 */
class TutorialChapter
{
    /**
   * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\Tutoriel", inversedBy="tutorialChapter")
   * @ORM\JoinColumn(nullable=false)
   */
  private $tutoriel;

  /**
   * @ORM\OneToMany(targetEntity="FBN\GuideBundle\Entity\TutorialChapterPara", mappedBy="tutorialChapter")
   * @ORM\OrderBy({"rank" = "ASC"})
   */
  private $TutorialChapterPara;

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
     */
    private $title;

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
     * Set tutoriel.
     *
     * @param \FBN\GuideBundle\Entity\Tutoriel $tutoriel
     *
     * @return TutorialChapter
     */
    public function setTutoriel(\FBN\GuideBundle\Entity\Tutoriel $tutoriel)
    {
        $this->tutoriel = $tutoriel;

        return $this;
    }

    /**
     * Get tutoriel.
     *
     * @return \FBN\GuideBundle\Entity\Tutoriel
     */
    public function getTutoriel()
    {
        return $this->tutoriel;
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
     * Add TutorialChapterPara.
     *
     * @param \FBN\GuideBundle\Entity\TutorialChapterPara $TutorialChapterPara
     *
     * @return Vigneron
     */
    public function addTutorialChapterPara(\FBN\GuideBundle\Entity\TutorialChapterPara $TutorialChapterPara)
    {
        $this->TutorialChapterPara[] = $TutorialChapterPara;
        $TutorialChapterPara->setVigneron($this);

        return $this;
    }

    /**
     * Remove TutorialChapterPara.
     *
     * @param \FBN\GuideBundle\Entity\TutorialChapterPara $TutorialChapterPara
     */
    public function removeTutorialChapterPara(\FBN\GuideBundle\Entity\TutorialChapterPara $TutorialChapterPara)
    {
        $this->TutorialChapterPara->removeElement($TutorialChapterPara);
    }

    /**
     * Get TutorialChapterPara.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTutorialChapterPara()
    {
        return $this->TutorialChapterPara;
    }
}
