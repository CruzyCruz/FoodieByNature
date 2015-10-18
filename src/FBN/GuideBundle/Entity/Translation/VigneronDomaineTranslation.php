<?php

namespace FBN\GuideBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Table(name="vignerondomainetranslation", indexes={
 *      @ORM\Index(name="vignerondomainetranslation_idx", columns={"locale", "object_class", "field", "foreign_key"})
 * })
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 */
class VigneronDomaineTranslation extends AbstractTranslation
{
    /**
     * All required columns are mapped through inherited superclass
     */
}