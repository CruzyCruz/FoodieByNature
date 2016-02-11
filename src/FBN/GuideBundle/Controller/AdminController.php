<?php

namespace FBN\GuideBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use FBN\GuideBundle\Form\ImageRestaurantType;

//use FBN\GuideBundle\Form\CoordinatesType;

class AdminController extends BaseAdminController
{
    public function createRestaurantEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        $formBuilder
            ->add('image', ImageRestaurantType::class)
            //->add('coordinates', CoordinatesType::class)
        ;

        return $formBuilder;
    }
}
