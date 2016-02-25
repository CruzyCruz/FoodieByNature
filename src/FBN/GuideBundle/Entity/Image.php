<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Image.
 *
 * @Gedmo\TranslationEntity(class="FBN\GuideBundle\Entity\Translation\ImageTranslation")
 * @ORM\MappedSuperclass
 */
class Image
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * Property overridden in child class for custom VichUploaderBundle annotation.
     *
     * @var File
     */
    private $file;

    /**
     * @var int
     *
     * @ORM\Column(name="rank", type="integer")
     */
    private $rank = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="legend", type="string", length=255)
     * @Gedmo\Translatable
     */
    private $legend;

    /**
     * @var string
     *
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    protected $locale;

    /**
     * Requirement for VichUploaderBundle.
     * It is required that at least one field changes if you are using doctrine
     * otherwise the event listeners won't be called and the file is lost.
     * 
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * Store the relative path to actual file.
     * 
     * @var null|string
     */
    private $relativePathToActualFile;

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
     * Set name.
     *
     * @param string $name
     *
     * @return Image
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
     * Set rank.
     *
     * @param int $rank
     *
     * @return Image
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
     * Set legend.
     *
     * @param string $legend
     *
     * @return Image
     */
    public function setLegend($legend)
    {
        $this->legend = $legend;

        return $this;
    }

    /**
     * Get legend.
     *
     * @return string
     */
    public function getLegend()
    {
        return $this->legend;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Image
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set relativePathToActualFile.
     *
     * @param string $relativePathToActualFile
     *
     * @return Image
     */
    public function setRelativePathToActualFile($relativePathToActualFile)
    {
        $this->relativePathToActualFile = $relativePathToActualFile;

        return $this;
    }

    /**
     * Get relativePathToActualFile.
     *
     * @return string
     */
    public function getRelativePathToActualFile()
    {
        return $this->relativePathToActualFile;
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
     * Set file.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return File
     */
    public function setFile(File $image = null)
    {
        $this->file = $image;

        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * Get file.
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getName();
    }
}
