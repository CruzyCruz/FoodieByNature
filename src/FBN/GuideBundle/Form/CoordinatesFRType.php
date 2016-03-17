<?php

namespace FBN\GuideBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FBN\GuideBundle\Entity\CoordinatesFRCityRepository;

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
                ))
            ->add('laneName', TextType::class)
            ->add('miscellaneous', TextType::class)
            ->add('locality', TextType::class)
            ->add('metro', TextType::class)
            ->add('coordinatesFRCity', EntityType::class, array(
                'class' => 'FBNGuideBundle:CoordinatesFRCity',
                'property' => 'display',
                'query_builder' => function (CoordinatesFRCityRepository $repo) {
                    return $repo->getAscendingSortedCitiesQueryBuilder();
                    },
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
