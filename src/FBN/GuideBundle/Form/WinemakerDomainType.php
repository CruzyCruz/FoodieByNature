<?php

namespace FBN\GuideBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\RequestStack;
use FBN\GuideBundle\Translation\TranslationManager;

class WinemakerDomainType extends AbstractType
{
    private static $fieldsToBeDisabled = array(
        'domain',
        'tel',
        'site',
        'href',
        'winemakerArea',
        'coordinates',
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
            ->add('domain', TextType::class)
            ->add('tel', TextType::class)
            ->add('site', TextType::class)
            ->add('href', TextType::class)
            ->add('openingHours', TextType::class)
            ->add('winemakerArea', EntityType::class, array(
                'class' => 'FBNGuideBundle:WinemakerArea',
                'property' => 'area',
                ))
            ->add('coordinates', CoordinatesType::class);

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
            'data_class' => 'FBN\GuideBundle\Entity\WinemakerDomain',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fbn_guidebundle_winemakerdomain';
    }
}
