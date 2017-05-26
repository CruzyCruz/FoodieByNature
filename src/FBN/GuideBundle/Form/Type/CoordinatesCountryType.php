<?php

namespace FBN\GuideBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FBN\GuideBundle\Entity\CoordinatesCountry;

class CoordinatesCountryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', TextType::class)
            ->add('codeISO', TextType::class)
            ->add('latitude', TextType::class)
            ->add('longitude', TextType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CoordinatesCountry::class,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'fbn_guidebundle_coordinatescountry';
    }
}
