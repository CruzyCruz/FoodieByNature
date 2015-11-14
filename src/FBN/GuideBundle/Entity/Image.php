<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Image
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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
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
     * @ORM\Column(name="nom", type="string", length=255)
     * @Gedmo\UploadableFileName
     */
    private $nom;

    /**
     * @var decimal
     *
     * @ORM\Column(name="taille", type="decimal")
     * @Gedmo\UploadableFileSize
     */
    private $taille;

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
     * @ORM\Column(name="legende", type="string", length=255)
     * @Gedmo\Translatable
     */
    private $legende;

    /**
     * @var string
     *
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;  

    /**
     * Set imageType
     *
     * @param \FBN\GuideBundle\Entity\Image $imageType
     * @return Image
     */
    public function setImageType(\FBN\GuideBundle\Entity\ImageType $imageType)
    {
        $this->imageType = $imageType;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return Image
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Image
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set taille
     *
     * @param string $taille
     * @return Image
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * Get taille
     *
     * @return string 
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     * @return Image
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string 
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set legende
     *
     * @param string $legende
     * @return Image
     */
    public function setLegende($legende)
    {
        $this->legende = $legende;

        return $this;
    }

    /**
     * Get legende
     *
     * @return string 
     */
    public function getLegende()
    {
        return $this->legende;
    }

    /**
     * Set locale
     *
     * @param string $locale
     * 
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }     

    /**
     * Renvoie le chemin relatif du répertoire de stockage des images depuis web
     *    
     * @return string
     * 
     */
    public function getWebPath()
    {
        $pos = strpos($this->path, 'uploads');
        $dir = substr($this->path, $pos);

        return $dir . '/' . $this->nom;
    }      
}
