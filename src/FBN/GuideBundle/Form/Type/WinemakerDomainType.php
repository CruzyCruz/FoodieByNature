<?php

namespace FBN\GuideBundle\Form\Type;

use FBN\GuideBundle\Form\Manager\FormManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
     * @var FormManager
     */
    private $formManager;

    public function __construct(RequestStack $requestStack, FormManager $formManager)
    {
        $this->requestStack = $requestStack;
        $this->formManager = $formManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $masterRequest = $this->requestStack->getMasterRequest();

        $builder
            ->add('domain', TextType::class, array(
                'required' => false,
                ))
            ->add('tel', TextType::class, array(
                'required' => false,
                ))
            ->add('site', TextType::class, array(
                'required' => false,
                ))
            ->add('href', TextType::class, array(
                'required' => false,
                ))
            ->add('openingHours', TextType::class)
            ->add('winemakerArea', EntityType::class, array(
                'class' => 'FBNGuideBundle:WinemakerArea',
                'property' => 'area',
                ))
            ->add('coordinates', CoordinatesType::class);

        $this->formManager->disableNonTranslatableFormFieldsForNonDefaultLocale(
            $builder,
            self::$fieldsToBeDisabled,
            $masterRequest->getLocale())
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FBN\GuideBundle\Entity\WinemakerDomain',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'fbn_guidebundle_winemakerdomain';
    }
}
