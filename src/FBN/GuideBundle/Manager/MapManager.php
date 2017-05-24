<?php

namespace FBN\GuideBundle\Manager;

use Ivory\GoogleMap\Map as IvoryMap;
use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Overlays\Marker;

class MapManager
{
    // proximity zoom restaurants / events
    const ZOOM_CLOSE = 15;
    //zoom winemaker if only on marker
    const ZOOM_WINEMAKER = 10;
    // google maps display world
    const WORLD_DIM_HEIGHT = 256;
    const WORLD_DIM_WIDTH = 256;
    // zoom maxi google maps
    const ZOOM_MAX = 21;
    // dimension of the element displaying the maps
    const MAP_DIM_HEIGHT = 300;
    const MAP_DIM_WIDTH = 300;

    protected $section;
    protected $nbMarkers;
    protected $lat;
    protected $lng;
    protected $center;
    protected $sw;
    protected $ne;
    protected $zoom;

    public function getMap(array $latlngs, $section)
    {
        $this->hydrate($latlngs, $section);

        $map = new IvoryMap();

        // Disable the auto zoom flag
        $map->setAutoZoom(false);

        // Sets the center
        $map->setCenter($this->center['lat'], $this->center['lng'], true);

        // Sets the zoom
        $map->setMapOption('zoom', $this->zoom);

        foreach ($latlngs as $latlng) {
            $marker = new Marker();

            $map->addMarker($marker);

            // Configure your marker options
            $marker->setPrefixJavascriptVariable('marker_');
            $marker->setPosition($latlng['lat'], $latlng['lng'], true);
            $marker->setAnimation(Animation::DROP);

            $marker->setOption('clickable', false);
            $marker->setOption('flat', true);
            $marker->setOptions(array(
                'clickable' => false,
                'flat' => true,
            ));
        }

        return $map;
    }

    public function hydrate(array $latlngs, $section)
    {
        $this->setsection($section);
        $this->setNbMarkers($latlngs);
        $this->setLatLng($latlngs);
        $this->setCenter();
        $this->setSW();
        $this->setNE();
        $this->setZoom(self::MAP_DIM_HEIGHT, self::MAP_DIM_WIDTH);
    }

    protected function latRad($lat)
    {
        $sin = sin($lat * pi() / 180);
        $radX2 = log((1 + $sin) / (1 - $sin)) / 2;

        return max(min($radX2, pi()), -pi()) / 2;
    }

    protected function zoom($mapPx, $worldPx, $fraction)
    {
        return floor(log($mapPx / $worldPx / $fraction)) / log(2);
    }

    protected function setsection($section)
    {
        $this->section = $section;
    }

    protected function setNbMarkers(array $latlngs)
    {
        $this->nbMarkers = count($latlngs);
    }

    protected function setLatLng(array $latlngs)
    {
        foreach ($latlngs as $latlng) {
            $lt[] = $latlng['lat'];
            $lg[] = $latlng['lng'];
        }

        $this->lat = $lt;
        $this->lng = $lg;
    }

    protected function setCenter()
    {
        $this->center['lat'] = array_sum($this->lat) / count($this->lat);
        $this->center['lng'] = array_sum($this->lng) / count($this->lng);
    }

    protected function setSW()
    {
        $this->sw['lat'] = min($this->lat);
        $this->sw['lng'] = min($this->lng);
    }

    protected function setNE()
    {
        $this->ne['lat'] = max($this->lat);
        $this->ne['lng'] = max($this->lng);
    }

    public function setZoom($mapDimH, $mapDimW)
    {
        $latFraction = ($this->latRad($this->ne['lat']) - $this->latRad($this->sw['lat'])) / pi();

        $lngDiff = $this->ne['lng'] - $this->sw['lng'];

        $lngFraction = (($lngDiff < 0) ? ($lngDiff + 360) : $lngDiff) / 360;

        if ($this->section == 'restaurant' || $this->section == 'event' || $this->section == 'shop') {
            $this->zoom = self::ZOOM_CLOSE;
        } elseif ($this->section == 'winemaker' && $this->nbMarkers == 1) {
            $this->zoom = self::ZOOM_WINEMAKER;
        } else {
            $latZoom = $this->zoom($mapDimH, self::WORLD_DIM_HEIGHT, $latFraction);
            $lngZoom = $this->zoom($mapDimW, self::MAP_DIM_WIDTH, $lngFraction);

            $this->zoom = min(self::ZOOM_WINEMAKER, floor(min($latZoom, $lngZoom)), self::ZOOM_MAX);
        }
    }
}
