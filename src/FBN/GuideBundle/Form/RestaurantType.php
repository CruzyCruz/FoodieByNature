<?php

namespace FBN\GuideBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RestaurantType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('author', 'text')
            ->add('description', 'textarea')
            ->add('restaurateur', 'text')
            ->add('tel', 'text')
            ->add('site', 'text')
            ->add('href', 'text')
            ->add('openingHours', 'text')
            ->add('publication', 'checkbox', array('required' => false))
            ->add('restaurantPrice', 'entity', array(
                'class' => 'FBNGuideBundle:RestaurantPrice',
                'property' => 'price',
                ))
            ->add('restaurantStyle', 'entity', array(
                'class' => 'FBNGuideBundle:RestaurantStyle',
                'property' => 'style',
                'multiple' => true,
                ))
            ->add('restaurantBonus', 'entity', array(
                'class' => 'FBNGuideBundle:RestaurantBonus',
                'property' => 'bonus',
                'multiple' => true,
                ))
            ->add('image', new ImageRestaurantType())
            ->add('save', 'submit')
            //->add('coordinates')
            //->add('shop')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FBN\GuideBundle\Entity\Restaurant',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fbn_guidebundle_restaurant';
    }
}
