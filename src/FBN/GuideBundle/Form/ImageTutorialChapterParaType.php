<?php

namespace FBN\GuideBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\HttpFoundation\RequestStack;
use FBN\GuideBundle\Translation\TranslationManager;

class ImageTutorialChapterParaType extends AbstractType
{
    private static $fieldsToBeDisabled = array(
        'file',
    );

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var TranslationManager
     */
    private $translationManager;

    public function __construct(RequestStack $requestStack, TranslationManager $translationManager)
    {
        $this->requestStack = $requestStack;
        $this->translationManager = $translationManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('legend', TextType::class)
            ->add('file', VichImageType::class, array(
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
                ))
        ;

        $this->translationManager->disableNonTranslatableFormFieldsForNonDefaultLocale(
            $builder,
            self::$fieldsToBeDisabled,
            $this->requestStack->getMasterRequest()->getLocale())
        ;
    }

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
