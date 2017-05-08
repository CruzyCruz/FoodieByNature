<?php

namespace FBN\GuideBundle\Manager;

use Exception;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Geocoder\Geocoder;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\UnitOfWork;
use FBN\GuideBundle\Entity\CoordinatesISO;
use FBN\GuideBundle\Entity\Coordinates;

class CoordinatesManager
{
    /**
     * Earth Radius (km).
     */
    const EARTH_RADIUS = 6371;

    /**
     * This is the maximum distance allowed between city coordinates and geocoded coordinates (km).
     */
    const MAX_DISTANCE = 15;

    /**
     * @var Geocoder
     */
    private $geocoder;

    /**
     * @var PropertyAccessor
     */
    protected $accessor;

    public function __construct(Geocoder $geocoder)
    {
        $this->geocoder = $geocoder;
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * Set|Update attributes lat/long on CoordinatesISO insertion|update (onFlush event).
     *
     * @param object $entity the entity
     * @param object $em     the entity manager
     * @param object $uow    the unit of work
     */
    public function setLatLongCoordinatesISOOnFlush($entity, ObjectManager $em, UnitOfWork $uow)
    {
        if ($entity instanceof CoordinatesISO) {
            $coordinatesISOCity = $this->getCoordinatesISOString($entity, 'City');

            $geocodingAdress = $this->buildGeocodingAddress($entity);
            $latLng = $this->getLatLong($geocodingAdress, $coordinatesISOCity->getLatitude(), $coordinatesISOCity->getLongitude());

            $entity->setLatitude($latLng['lat']);
            $entity->setLongitude($latLng['lng']);

            $classMetadata = $em->getClassMetadata(get_class($entity));
            $uow->recomputeSingleEntityChangeSet($classMetadata, $entity);
        }
    }

    /**
     * Build postal adress fields for geocoding or display in views.
     *
     * @param CoordinatesISO $coordinatesISO
     *
     * @return array array : ['lane', 'locality', 'city', 'country']
     */
    public function buildPostalAddressFields(CoordinatesISO $coordinatesISO)
    {
        $coordinatesISOCity = $this->getCoordinatesISOString($coordinatesISO, 'City');
        $coordinatesISOLane = $this->getCoordinatesISOString($coordinatesISO, 'Lane');
        $coordinatesCountry = $coordinatesISO->getCoordinates()->getCoordinatesCountry();

        $miscellaneous = $coordinatesISO->getMiscellaneous();
        $laneNum = $coordinatesISO->getLaneNum();
        $lane = null;
        if (null !== $coordinatesISOLane) {
            $lane = $coordinatesISOLane->getLane();
        }
        $laneName = $coordinatesISO->getLaneName();
        $locality = $coordinatesISO->getLocality();

        $postCode = $coordinatesISOCity->getPostCode();
        $city = $coordinatesISOCity->getCity();

        $country = $coordinatesCountry->getCountry();

        $delimiter = '';

        if (null !== $laneName && null !== $laneNum) {
            $delimiter = ', ';
        }

        return array(
            'miscellaneous' => $miscellaneous,
            'lane' => $laneNum.$delimiter.$lane.' '.$laneName,
            'locality' => $locality,
            'city' => $postCode.$delimiter.$city,
            'country' => $country,
            )
        ;
    }

    public function buildGeocodingAddress(CoordinatesISO $coordinatesISO)
    {
        $addressFields = $this->buildPostalAddressFields($coordinatesISO);

        return $addressFields['lane'].', '.$addressFields['locality'].', '.$addressFields['city'].', '.$addressFields['country'];
    }

    public function buildViewAddress(CoordinatesISO $coordinatesISO)
    {
        $addressFields = $this->buildPostalAddressFields($coordinatesISO);

        $delimiter = '';

        if (null !== $addressFields['miscellaneous']) {
            $delimiter = ', ';
        }

        return $addressFields['miscellaneous'].$delimiter.$addressFields['lane'].', '.$addressFields['locality'].', '.$addressFields['city'].', '.$addressFields['country'];
    }

    /**
     * Determine lat/long using geocoding.
     *
     * @param string $geocodingAdress
     * @param float  $latCity
     * @param float  $lngCity
     *
     * @return array array : ['lat', 'long']
     */
    private function getLatLong($geocodingAdress, $latCity, $lngCity)
    {
        $latLng = array(
            'lat' => $latCity,
            'lng' => $lngCity,
            )
        ;

        try {
            $addressCollection = $this->geocoder->geocode($geocodingAdress);
        } catch (Exception $e) {
            return $latLng;
        }

        $max = self::MAX_DISTANCE;

        foreach ($addressCollection->all() as $address) {
            $lat = $address->getCoordinates()->getLatitude();
            $lng = $address->getCoordinates()->getLongitude();
            $dist = $this->computeDistanceBetweenTwoPoints($lat, $lng, $latCity, $lngCity);

            if ($dist <= $max) {
                $max = $dist;
                $latLng = array(
                    'lat' => floatval($lat),
                    'lng' => floatval($lng),
                    )
                ;
            }
        }

        return $latLng;
    }

    /**
     * Compute distance between two points on earth.
     *
     * @param float $lat1
     * @param float $lng1
     * @param float $lat2
     * @param float $lng2
     *
     * @return float the distance between two points on earth (km)
     */
    private function computeDistanceBetweenTwoPoints($lat1, $lng1, $lat2, $lng2)
    {
        $lat1 = floatval($lat1);
        $lng1 = floatval($lng1);
        $lat2 = floatval($lat2);
        $lng2 = floatval($lng2);

        return
            self::EARTH_RADIUS
            *
            acos(
                cos(deg2rad($lat1))
                *
                cos(deg2rad($lat2))
                *
                cos(deg2rad($lng2) - deg2rad($lng1))
                +
                sin(deg2rad($lat1))
                *
                sin(deg2rad($lat2))
            )
        ;
    }

    /**
     * Access any property from class CoordinatesISO named coordinatesISO"String" with:.
     * - ISO = FR / EN...
     * - String = City / Lane...
     *
     * @param CoordinatesISO $coordinatesISO
     * @param string         $string
     *
     * @return mixed the property value
     */
    private function getCoordinatesISOString(CoordinatesISO $coordinatesISO, $string)
    {
        $classInfo = new \ReflectionClass($coordinatesISO);
        $className = $classInfo->getShortName();

        return $this->accessor->getValue($coordinatesISO, $className.$string);
    }

    /**
     * Find the entity linked to one coordinates (Restaurant, Shop, WinemakerDomain, EventPast).
     *
     * @param Coordinates $coordinates
     *
     * @return object $entity the related entity
     */
    public function findEntityLinkedToCoordinates(Coordinates $coordinates)
    {
        ($entity = $coordinates->getRestaurant())
        || ($entity = $coordinates->getShop())
        || ($entity = $coordinates->getWinemakerDomain())
        || ($entity = $coordinates->getEvent());

        return $entity;
    }
}
