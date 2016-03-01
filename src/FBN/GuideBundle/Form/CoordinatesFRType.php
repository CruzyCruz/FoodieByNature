<?php

namespace FBN\GuideBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CoordinatesFRType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('laneNum', 'text')
            ->add('coordinatesFRLane', 'entity', array(
                'class' => 'FBNGuideBundle:CoordinatesFRLane',
                'property' => 'lane',
                ))
            ->add('laneName', 'text')
            ->add('miscellaneous', 'text')
            ->add('locality', 'text')
            ->add('postcode', 'text')
            ->add('city', 'text')
            ->add('metro', 'text')
            ->add('latitude', 'text')
            ->add('longitude', 'text')
            ->add('coordinatesFRDept', 'entity', array(
                'class' => 'FBNGuideBundle:CoordinatesFRDept',
                'property' => 'department',
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FBN\GuideBundle\Entity\CoordinatesFR',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fbn_guidebundle_coordinatesfr';
    }
}
