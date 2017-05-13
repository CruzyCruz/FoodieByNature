<?php

namespace FBN\GuideBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use FBN\GuideBundle\Form\Manager\FormManager;

class ImageType extends AbstractType
{
    protected static $fieldsToBeDisabled = array(
        'file',
    );

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var FormManager
     */
    protected $formManager;

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
            $masterRequest->getLocale())
        ;
    }
}
