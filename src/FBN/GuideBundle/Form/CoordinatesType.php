<?php

namespace FBN\GuideBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CoordinatesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('coordinatesCountry', EntityType::class, array(
                'class' => 'FBNGuideBundle:CoordinatesCountry',
                'property' => 'country',
                ))
            ->add('coordinatesFR', CoordinatesFRType::class)
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FBN\GuideBundle\Entity\Coordinates',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fbn_guidebundle_coordinates';
    }
}
