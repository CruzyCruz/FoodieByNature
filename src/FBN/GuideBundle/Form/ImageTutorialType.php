<?php

namespace FBN\GuideBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\HttpFoundation\RequestStack;
use FBN\GuideBundle\Form\Manager\FormManager;

class ImageTutorialType extends AbstractType
{
    private static $fieldsToBeDisabled = array(
        'file',
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

        $requiredFile = $this->formManager->isFileFieldRequired($masterRequest);

        $builder
            ->add('legend', TextType::class, array(
                'required' => true,
                ))
            ->add('file', VichImageType::class, array(
                'required' => $requiredFile,
                'allow_delete' => false, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
                ))
        ;

        $this->formManager->disableNonTranslatableFormFieldsForNonDefaultLocale(
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
            'data_class' => 'FBN\GuideBundle\Entity\ImageTutorial',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fbn_guidebundle_imagetutorial';
    }
}
