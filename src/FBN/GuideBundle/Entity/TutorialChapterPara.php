<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\ImageTutorialChapterPara", inversedBy="tutorialChapterPara", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Assert\Valid()
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
     * @Assert\NotBlank()         
     */
    private $paragraph;

    /**
     * @var int
     *
     * @ORM\Column(name="rank", type="integer")
     */
    private $rank;

    /**
     * @Gedmo\Slug(updatable=true, unique=false, fields={"rank"}, prefix="-para-")
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
     * Set slug.
     *
     * @param string $slug
     *
     * @return TutorialChapterPara
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
     * @param \FBN\GuideBundle\Entity\ImageTutorialChapterPara $image
     *
     * @return TutorialChapterPara
     */
    public function setImage(\FBN\GuideBundle\Entity\ImageTutorialChapterPara $image)
    {
        $this->image = $image;
        $image->setTutorialChapterPara($this);

        return $this;
    }

    /**
     * Get image.
     *
     * @return \FBN\GuideBundle\Entity\ImageTutorialChapterPara
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
