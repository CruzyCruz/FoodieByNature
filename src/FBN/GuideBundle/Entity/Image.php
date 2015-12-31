<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Image.
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\ImageRepository")
 * @Gedmo\Uploadable(path="/my/path", filenameGenerator="SHA1", allowOverwrite=true, appendNumber=true)
 * @Gedmo\TranslationEntity(class="FBN\GuideBundle\Entity\Translation\ImageTranslation")
 */
class Image
{
    /**
     * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\ImageType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $imageType;

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
     * @ORM\Column(name="path", type="string", length=255)
     * @Gedmo\UploadableFilePath
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Gedmo\UploadableFileName
     */
    private $name;

    /**
     * @var decimal
     *
     * @ORM\Column(name="size", type="decimal")
     * @Gedmo\UploadableFileSize
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="mimeType", type="string", length=255)
     * @Gedmo\UploadableFileMimeType
     */
    private $mimeType;

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
    private $locale;

    /**
     * Set imageType.
     *
     * @param \FBN\GuideBundle\Entity\Image $imageType
     *
     * @return Image
     */
    public function setImageType(\FBN\GuideBundle\Entity\ImageType $imageType)
    {
        $this->imageType = $imageType;

        return $this;
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
     * Set path.
     *
     * @param string $path
     *
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
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
     * Set size.
     *
     * @param string $size
     *
     * @return Image
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size.
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set mimeType.
     *
     * @param string $mimeType
     *
     * @return Image
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType.
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
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
     * Set locale.
     *
     * @param string $locale
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Renvoie le chemin relatif du répertoire de stockage des images depuis web.
     *    
     * @return string
     */
    public function getWebPath()
    {
        $pos = strpos($this->path, 'uploads');
        $dir = substr($this->path, $pos);

        return $dir.'/'.$this->name;
    }

    /**
     * Get imageType.
     *
     * @return \FBN\GuideBundle\Entity\ImageType
     */
    public function getImageType()
    {
        return $this->imageType;
    }

    /** {@inheritdoc} */
    public function __toString()
    {
        return $this->getName();
    }
}
