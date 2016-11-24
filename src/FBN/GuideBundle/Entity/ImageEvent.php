<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * ImageEvent.
 *
 * @ORM\Table(name="image_event")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\ImageEventRepository")
 * @Vich\Uploadable
 */
class ImageEvent extends Image
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
     * @ORM\OneToOne(targetEntity="FBN\GuideBundle\Entity\Event", mappedBy="image")
     */
    private $event;

    /**
     * @Vich\UploadableField(mapping="image_event", fileNameProperty="name")
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
     * Set event.
     *
     * @param \FBN\GuideBundle\Entity\Event $event
     *
     * @return ImageEvent
     */
    public function setEvent(\FBN\GuideBundle\Entity\Event $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event.
     *
     * @return \FBN\GuideBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Build Image name.
     *
     * @return null|string
     */
    public function buildImageRootName()
    {
        if (null !== $this->getEvent()) {
            return $this->getEvent()->getSlug();
        }

        return;
    }
}
