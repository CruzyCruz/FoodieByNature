<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\TutorialChapterPara", mappedBy="image")
     */
    private $tutorialChapterPara;

    /**
     * @Vich\UploadableField(mapping="image_tutorial_chapter_para", fileNameProperty="name")
     * @Assert\Expression("this.getFile() or this.getName()", message="fbn.guide.admin.image.upload")
     * @Assert\Image(
     *     maxSize = "300k",
     *     mimeTypes = {"image/jpeg"},
     *     mimeTypesMessage = "fbn.guide.admin.image.mimeType",
     *     minWidth = 100,
     *     maxWidth = 1000,
     *     minHeight = 100,
     *     maxHeight = 1000
     * )
     *
     * @var File
     */
    protected $file;

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
     * Set tutorialChapterPara.
     *
     * @param \FBN\GuideBundle\Entity\TutorialChapterPara $tutorialChapterPara
     *
     * @return ImageTutorialChapterPara
     */
    public function setTutorialChapterPara(\FBN\GuideBundle\Entity\TutorialChapterPara $tutorialChapterPara)
    {
        $this->tutorialChapterPara = $tutorialChapterPara;

        return $this;
    }

    /**
     * Get tutorialChapterPara.
     *
     * @return \FBN\GuideBundle\Entity\TutorialChapterPara
     */
    public function getTutorialChapterPara()
    {
        return $this->tutorialChapterPara;
    }

    /**
     * Build Image name.
     *
     * @return null|string
     */
    public function buildImageRootName()
    {
        if (null !== $tutoChapterPara = $this->getTutorialChapterPara()) {
            if (null !== $tutoChapter = $tutoChapterPara->getTutorialChapter()) {
                if (null !== $tuto = $tutoChapter->getTutorial()) {
                    $slugTuto = $tuto->getSlug();
                    $slugTutoChapter = $tutoChapter->getSlug();
                    $slugTutoChapterPara = $tutoChapterPara->getSlug();

                    return $slugTuto.$slugTutoChapter.$slugTutoChapterPara;
                }

                return;
            }

            return;
        }

        return;
    }
}
