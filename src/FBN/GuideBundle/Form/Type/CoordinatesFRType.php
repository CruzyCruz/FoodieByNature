<?php

namespace FBN\GuideBundle\Form\Type;

use JavierEguiluz\Bundle\EasyAdminBundle\Form\Type\EasyAdminAutocompleteType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FBN\GuideBundle\Entity\CoordinatesFR;
use FBN\GuideBundle\Entity\CoordinatesFRCity;
use FBN\GuideBundle\Entity\CoordinatesFRLane;

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
                'class' => CoordinatesFRLane::class,
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
            ->add('metro', TextType::class, array(
                'required' => false,
                ))
            ->add('coordinatesFRCity', EasyAdminAutocompleteType::class, array(
                'class' => CoordinatesFRCity::class,
                ))
        ;

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            if (!isset($data["coordinatesFRCity"])) {
                $data["coordinatesFRCity"]["autocomplete"] = "";
                $event->setData($data);
            }
        });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => CoordinatesFR::class,
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'fbn_guidebundle_coordinatesfr';
    }
}
