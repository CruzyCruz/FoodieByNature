<?php

namespace FBN\GuideBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FBN\GuideBundle\Entity\CoordinatesFRCityRepository;
use FBN\GuideBundle\Entity\CoordinatesFR as CoordFR;
use Symfony\Component\Form\FormInterface;

class CoordinatesFRType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('laneNum', TextType::class)
            ->add('coordinatesFRLane', EntityType::class, array(
                'class' => 'FBNGuideBundle:CoordinatesFRLane',
                'property' => 'lane',
                'placeholder' => 'label.form.empty_value',
                ))
            ->add('laneName', TextType::class)
            ->add('miscellaneous', TextType::class, array(
                'required' => false,
                ))
            ->add('locality', TextType::class, array(
                'required' => false,
                ))
            ->add('metro', TextType::class,  array(
                'required' => false,
                ))
            ->add('coordinatesFRCity', EntityType::class, array(
                'class' => 'FBNGuideBundle:CoordinatesFRCity',
                'property' => 'display',
                'query_builder' => function (CoordinatesFRCityRepository $repo) {
                    return $repo->getAscendingSortedCitiesQueryBuilder();
                    },
                'placeholder' => 'label.form.empty_value',
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
            // Ensures that validation error messages will be correctly displayed next to each field 
            // of the corresponding nested form (i.e if submission and CoordinatesFR nested form with all fields empty)
            'empty_data' => function (FormInterface $form) {
                return new CoordFR();
            },
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
