<?php

namespace FBN\GuideBundle\Utils;

class Entity
{
    public static function compareDate($a, $b)
    {
        $d1 = $a->getDatePublication();
        $d2 = $b->getDatePublication();

        if ($d1 == $d2) {
            return 0;
        }

        return ($d1 > $d2) ? -1 : 1;
    }
}
