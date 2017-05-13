<?php

namespace FBN\GuideBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageTutorialChapterParaType extends ImageType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FBN\GuideBundle\Entity\ImageTutorialChapterPara',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fbn_guidebundle_imagetutorialchapterpara';
    }
}
