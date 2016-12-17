<?php

namespace FBN\GuideBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JavierEguiluz\Bundle\EasyAdminBundle\Form\Type\EasyAdminAutocompleteType;
use FBN\GuideBundle\Entity\CoordinatesFRCity;

class CoordinatesFRType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('laneNum', TextType::class, array(
                'required' => false,
                ))
            ->add('coordinatesFRLane', EntityType::class, array(
                'class' => 'FBNGuideBundle:CoordinatesFRLane',
                'property' => 'lane',
                'placeholder' => 'label.form.empty_value',
                'required' => false,
                ))
            ->add('laneName', TextType::class, array(
                'required' => false,
                ))
            ->add('miscellaneous', TextType::class, array(
                'required' => false,
                ))
            ->add('locality', TextType::class, array(
                'required' => false,
                ))
            ->add('metro', TextType::class,  array(
                'required' => false,
                ))
            ->add('coordinatesFRCity', EasyAdminAutocompleteType::class, array(
                'class' => CoordinatesFRCity::class,
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
