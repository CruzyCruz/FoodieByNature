<?php

namespace FBN\GuideBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoordinatesFRCity.
 *
 * @ORM\Table(name="coordinates_fr_city")
 * @ORM\Entity(repositoryClass="FBN\GuideBundle\Entity\CoordinatesFRCityRepository")
 */
class CoordinatesFRCity
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
     * @var string
     *
     * @ORM\Column(name="areaPre2016", type="string", length=255)
     */
    private $areaPre2016;

    /**
     * @var string
     *
     * @ORM\Column(name="areaPost2016", type="string", length=255)
     */
    private $areaPost2016;

    /**
     * @var string
     *
     * @ORM\Column(name="deptNum", type="string", length=255)
     */
    private $deptNum;

    /**
     * @var string
     *
     * @ORM\Column(name="deptName", type="string", length=255)
     */
    private $deptName;

    /**
     * @var string
     *
     * @ORM\Column(name="district", type="integer")
     */
    private $district;

    /**
     * @var string
     *
     * @ORM\Column(name="postCode", type="integer")
     */
    private $postCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

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
     * Set areaPre2016.
     *
     * @param string $areaPre2016
     *
     * @return CoordinatesFRCity
     */
    public function setAreaPre2016($areaPre2016)
    {
        $this->areaPre2016 = $areaPre2016;

        return $this;
    }

    /**
     * Get areaPre2016.
     *
     * @return string
     */
    public function getAreaPre2016()
    {
        return $this->areaPre2016;
    }

    /**
     * Set areaPost2016.
     *
     * @param string $areaPost2016
     *
     * @return CoordinatesFRCity
     */
    public function setAreaPost2016($areaPost2016)
    {
        $this->areaPost2016 = $areaPost2016;

        return $this;
    }

    /**
     * Get areaPost2016.
     *
     * @return string
     */
    public function getAreaPost2016()
    {
        return $this->areaPost2016;
    }

    /**
     * Set deptNum.
     *
     * @param string $deptNum
     *
     * @return CoordinatesFRCity
     */
    public function setDeptNum($deptNum)
    {
        $this->deptNum = $deptNum;

        return $this;
    }

    /**
     * Get deptNum.
     *
     * @return string
     */
    public function getDeptNum()
    {
        return $this->deptNum;
    }

    /**
     * Set deptName.
     *
     * @param string $deptName
     *
     * @return CoordinatesFRCity
     */
    public function setDeptName($deptName)
    {
        $this->deptName = $deptName;

        return $this;
    }

    /**
     * Get deptName.
     *
     * @return string
     */
    public function getDeptName()
    {
        return $this->deptName;
    }

    /**
     * Set district.
     *
     * @param string $district
     *
     * @return CoordinatesFRCity
     */
    public function setDistrict($district)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district.
     *
     * @return string
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set postCode.
     *
     * @param string $postCode
     *
     * @return CoordinatesFRCity
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Get postCode.
     *
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set city.
     *
     * @param string $city
     *
     * @return CoordinatesFRCity
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get display (form).
     *
     * @return string
     */
    public function getDisplay()
    {
        return $this->city.' ('.$this->postCode.')';
    }
}
