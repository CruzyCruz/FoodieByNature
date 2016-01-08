<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * ImageTutorialChapterPara.
 *
 * @ORM\Table(name="image_tutorial_chapter_para")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\ImageTutorialChapterParaRepository")
 * @Vich\Uploadable
 */
class ImageTutorialChapterPara extends Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Vich\UploadableField(mapping="image_tutorial_chapter_para", fileNameProperty="name")
     *
     * @var File
     */
    private $file;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
