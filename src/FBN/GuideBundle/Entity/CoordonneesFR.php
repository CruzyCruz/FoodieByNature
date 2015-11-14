<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoordonneesFR
 *
 * @ORM\Table(name="coordonneesfr")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordonneesFRRepository")
 */
class CoordonneesFR
{

   /**
    * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordonneesFRVoie")
    * @ORM\JoinColumn(nullable=true)
    */
   private $coordonneesFRVoie;

   /**
    * @ORM\ManyToOne(targetEntity="FBN\GuideBundle\Entity\CoordonneesFRDept")
    * @ORM\JoinColumn(nullable=false)
    */
   private $coordonneesFRDept;

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
     * @ORM\Column(name="laneNum", type="string", length=255, nullable=true)
     */
    private $laneNum;

    /**
     * @var string
     *
     * @ORM\Column(name="voieNom", type="string", length=255, nullable=true)
     */
    private $voieNom;

    /**
     * @var string
     *
     * @ORM\Column(name="divers", type="string", length=255, nullable=true)
     */
    private $divers;

    /**
     * @var string
     *
     * @ORM\Column(name="lieudit", type="string", length=255, nullable=true)
     */
    private $lieudit;

    /**
     * @var string
     *
     * @ORM\Column(name="codePostal", type="string", length=255)
     */
    private $codePostal;    

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
     * Set laneNum
     *
     * @param string $laneNum
     * @return CordonneesFR
     */
    public function setLaneNum($laneNum)
    {
        $this->laneNum = $laneNum;

        return $this;
    }

    /**
     * Get laneNum
     *
     * @return string 
     */
    public function getLaneNum()
    {
        return $this->laneNum;
    }

    /**
     * Set coordonneesFRVoie
     *
     * @param \FBN\GuideBundle\Entity\CoordonneesFRVoie $coordonneesFRVoie
     * @return CoordonneesFR
     */
    public function setCoordonneesFRVoie(\FBN\GuideBundle\Entity\CoordonneesFRVoie $coordonneesFRVoie)
    {
        $this->coordonneesFRVoie = $coordonneesFRVoie;

        return $this;
    }

    /**
     * Get coordonneesFRVoie
     *
     * @return \FBN\GuideBundle\Entity\CoordonneesFRVoie 
     */
    public function getCoordonneesFRVoie()
    {
        return $this->coordonneesFRVoie;
    }

    /**
     * Set coordonneesFRDept
     *
     * @param \FBN\GuideBundle\Entity\CoordonneesFRDept $coordonneesFRDept
     * @return CoordonneesFR
     */
    public function setCoordonneesFRDept(\FBN\GuideBundle\Entity\CoordonneesFRDept $coordonneesFRDept)
    {
        $this->coordonneesFRDept = $coordonneesFRDept;

        return $this;
    }

    /**
     * Get coordonneesFRDept
     *
     * @return \FBN\GuideBundle\Entity\CoordonneesFRDept 
     */
    public function getCoordonneesFRDept()
    {
        return $this->coordonneesFRDept;
    }

    /**
     * Set voieNom
     *
     * @param string $voieNom
     * @return CoordonneesFR
     */
    public function setVoieNom($voieNom)
    {
        $this->voieNom = $voieNom;

        return $this;
    }

    /**
     * Get voieNom
     *
     * @return string 
     */
    public function getVoieNom()
    {
        return $this->voieNom;
    }

    /**
     * Set divers
     *
     * @param string $divers
     * @return Coordonnees
     */
    public function setDivers($divers)
    {
        $this->divers = $divers;

        return $this;
    }

    /**
     * Get divers
     *
     * @return string 
     */
    public function getDivers()
    {
        return $this->divers;
    }     

    /**
     * Set lieudit
     *
     * @param string $lieudit
     * @return Coordonnees
     */
    public function setLieudit($lieudit)
    {
        $this->lieudit = $lieudit;

        return $this;
    }

    /**
     * Get lieudit
     *
     * @return string 
     */
    public function getLieudit()
    {
        return $this->lieudit;
    } 

    /**
     * Set codePostal
     *
     * @param string $codePostal
     * @return CoordonneesFR
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string 
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }
}
