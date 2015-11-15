<?php

namespace FBN\GuideBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

/**
 * @ORM\Table(name="winemakerdomaintranslation", indexes={
 *      @ORM\Index(name="winemakerdomaintranslation_idx", columns={"locale", "object_class", "field", "foreign_key"})
 * })
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 */
class WinemakerDomainTranslation extends AbstractTranslation
{
    /*
     * All required columns are mapped through inherited superclass
     */
}
