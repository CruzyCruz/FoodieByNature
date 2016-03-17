<?php

namespace FBN\GuideBundle\Coordinates;

use Exception;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Geocoder\Geocoder;
use FBN\GuideBundle\Entity\CoordinatesISO;

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
     * @param object $entity The entity.
     * @param object $em     The entity manager.
     * @param object $uow    The unit of work.
     */
    public function setLatLongCoordinatesISOOnFlush($entity, $em, $uow)
    {
        if ($entity instanceof CoordinatesISO) {
            $coordinatesISOCity = $this->getCoordinatesISOString($entity, 'City');

            $addressFields = $this->buildPostalAddressFields($entity);
            $postalAddress = $addressFields['lane'].', '.$addressFields['locality'].', '.$addressFields['city'].', '.$addressFields['country'];
            $latLng = $this->getLatLong($postalAddress, $coordinatesISOCity->getLatitude(), $coordinatesISOCity->getLongitude());

            $entity->setLatitude($latLng['lat']);
            $entity->setLongitude($latLng['lng']);

            $classMetadata = $em->getClassMetadata(get_class($entity));
            $uow->recomputeSingleEntityChangeSet($classMetadata, $entity);
        }

        return;
    }

    /**
     * Build postal adress fields for geocoding or display in views.
     *
     * @param CoordinatesISO $coordinatesISO
     *
     * @return array Array : ['lane', 'locality', 'city', 'country'].
     */
    public function buildPostalAddressFields(CoordinatesISO $coordinatesISO)
    {
        $coordinatesISOCity = $this->getCoordinatesISOString($coordinatesISO, 'City');
        $coordinatesISOLane = $this->getCoordinatesISOString($coordinatesISO, 'Lane');

        $laneNum = $coordinatesISO->getLaneNum();
        $lane = null;
        if (null !== $coordinatesISOLane) {
            $lane = $coordinatesISOLane->getLane();
        }
        $laneName = $coordinatesISO->getLaneName();
        $locality = $coordinatesISO->getLocality();
        $country = $coordinatesISO->getCountry();

        $postCode = $coordinatesISOCity->getPostCode();
        $city = $coordinatesISOCity->getCity();

        $delimiter = '';

        if (null !== $laneName && null !== $laneNum) {
            $delimiter = ', ';
        }

        return array(
            'lane' => $laneNum.$delimiter.$lane.' '.$laneName,
            'locality' => $locality,
            'city' => $postCode.$delimiter.$city,
            'country' => $country,
            )
        ;
    }

    /**
     * Determine lat/long using geocoding.
     *
     * @param string $postalAddress
     * @param float  $latCity
     * @param float  $lngCity
     *
     * @return array Array : ['lat', 'long'].
     */
    private function getLatLong($postalAddress, $latCity, $lngCity)
    {
        $latLng = array(
            'lat' => $latCity,
            'lng' => $lngCity,
            )
        ;
        //$addressCollection = $this->geocoder->geocode($postalAddress);
        try {
            $addressCollection = $this->geocoder->geocode($postalAddress);
        } catch (Exception $e) {
            //dump($addressCollection);

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
     * @return float The distance between two points on earth (km).
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
     * @return mixed The property value.
     */
    private function getCoordinatesISOString(CoordinatesISO $coordinatesISO, $string)
    {
        $classInfo = new \ReflectionClass($coordinatesISO);
        $className = $classInfo->getShortName();

        return $this->accessor->getValue($coordinatesISO, $className.$string);
    }
}
