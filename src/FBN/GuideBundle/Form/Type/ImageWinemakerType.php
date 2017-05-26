<?php

namespace FBN\GuideBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;
use FBN\GuideBundle\Entity\ImageWinemaker;

class ImageWinemakerType extends ImageType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ImageWinemaker::class,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'fbn_guidebundle_imagewinemaker';
    }
}
