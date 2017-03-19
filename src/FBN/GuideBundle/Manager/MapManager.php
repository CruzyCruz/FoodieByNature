<?php

namespace FBN\GuideBundle\Manager;

use Ivory\GoogleMap\Map as IvoryMap;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Overlays\Animation;

class MapManager
{
    protected $section;
    protected $nbMarkers;
    protected $lat;
    protected $lng;
    protected $center;
    protected $sw;
    protected $ne;
    protected $zoom;

    protected $zoomClose;
    protected $zoomWinemaker;
    protected $worldDimHeight;
    protected $worldDimWidth;
    protected $zoomMax;
    protected $mapDimHeight;
    protected $mapDimWidth;

    public function __construct($zoomClose, $zoomWinemaker, $worldDimHeight, $worldDimWidth, $zoomMax, $mapDimHeight, $mapDimWidth)
    {
        $this->zoomClose = $zoomClose;
        $this->zoomWinemaker = $zoomWinemaker;
        $this->worldDimHeight = $worldDimHeight;
        $this->worldDimWidth = $worldDimWidth;
        $this->zoomMax = $zoomMax;
        $this->mapDimHeight = $mapDimHeight;
        $this->mapDimWidth = $mapDimWidth;
    }

    public function hydrate(array $latlngs, $section)
    {
        $this->setsection($section);
        $this->setNbMarkers($latlngs);
        $this->setLatLng($latlngs);
        $this->setCenter();
        $this->setSW();
        $this->setNE();
        $this->setZoom($this->mapDimHeight, $this->mapDimWidth);
    }

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
            $this->zoom = $this->zoomClose;
        } elseif ($this->section == 'winemaker' && $this->nbMarkers == 1) {
            $this->zoom = $this->zoomWinemaker;
        } else {
            $latZoom = $this->zoom($mapDimH, $this->worldDimHeight, $latFraction);
            $lngZoom = $this->zoom($mapDimW, $this->mapDimWidth, $lngFraction);

            $this->zoom = min($this->zoomWinemaker, floor(min($latZoom, $lngZoom)), $this->zoomMax);
        }
    }
}
