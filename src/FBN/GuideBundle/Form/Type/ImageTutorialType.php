<?php

namespace FBN\GuideBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;
use FBN\GuideBundle\Entity\ImageTutorial;

class ImageTutorialType extends ImageType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ImageTutorial::class,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'fbn_guidebundle_imagetutorial';
    }
}
