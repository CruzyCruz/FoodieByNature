<?php

namespace FBN\GuideBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;
use FBN\GuideBundle\Entity\ImageEvent;

class ImageEventType extends ImageType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ImageEvent::class,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'fbn_guidebundle_imageevent';
    }
}
