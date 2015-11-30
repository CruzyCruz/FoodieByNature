<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * TutorialChapterPara.
 *
 * @ORM\Table(name="tutorialchapterpara")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\TutorialChapterParaRepository")
 * @Gedmo\TranslationEntity(class="FBN\GuideBundle\Entity\Translation\TutorialChapterParaTranslation") 
 */
class TutorialChapterPara
{
    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\TutorialChapter", inversedBy="TutorialChapterPara")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tutorialChapter;

    /**
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Image", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

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
     * @ORM\Column(name="paragraph", type="text")
     * @Gedmo\Translatable          
     */
    private $paragraph;

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
     * Set paragraph.
     *
     * @param string $paragraph
     *
     * @return TutorialChapterPara
     */
    public function setParagraph($paragraph)
    {
        $this->paragraph = $paragraph;

        return $this;
    }

    /**
     * Get paragraph.
     *
     * @return string
     */
    public function getParagraph()
    {
        return $this->paragraph;
    }

    /**
     * Set rank.
     *
     * @param int $rank
     *
     * @return TutorialChapterPara
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
     * Set tutorialChapter.
     *
     * @param \FBN\GuideBundle\Entity\TutorialChapter $tutorialChapter
     *
     * @return TutorialChapterPara
     */
    public function setTutorialChapter(\FBN\GuideBundle\Entity\TutorialChapter $tutorialChapter)
    {
        $this->tutorialChapter = $tutorialChapter;

        return $this;
    }

    /**
     * Get tutorialChapter.
     *
     * @return \FBN\GuideBundle\Entity\TutorialChapter
     */
    public function getTutorialChapter()
    {
        return $this->tutorialChapter;
    }

    /**
     * Set image.
     *
     * @param \FBN\GuideBundle\Entity\Image $image
     *
     * @return TutorialChapterPara
     */
    public function setImage(\FBN\GuideBundle\Entity\Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return \FBN\GuideBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
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
}
