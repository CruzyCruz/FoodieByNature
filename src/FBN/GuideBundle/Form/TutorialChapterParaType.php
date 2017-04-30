<?php

namespace FBN\GuideBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class TutorialChapterParaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('paragraph', 'ckeditor', array(
                'config_name' => 'ck_editor_config',
                ))
            ->add('rank', HiddenType::class)
            ->add('image', ImageTutorialChapterParaType::class)
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FBN\GuideBundle\Entity\TutorialChapterPara',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fbn_guidebundle_tutorialchapterpara';
    }
}
