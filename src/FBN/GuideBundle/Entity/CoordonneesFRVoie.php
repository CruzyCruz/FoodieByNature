<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoordonneesFRVoie
 *
 * @ORM\Table(name="coordonneesfrvoie")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordonneesFRVoieRepository")
 */
class CoordonneesFRVoie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="voie", type="string", length=255, unique=true)
     */
    private $voie;


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
     * Set voie
     *
     * @param string $voie
     * @return CoordonneesFRVoie
     */
    public function setVoie($voie)
    {
        $this->voie = $voie;

        return $this;
    }

    /**
     * Get voie
     *
     * @return string 
     */
    public function getVoie()
    {
        return $this->voie;
    }
}
