<?php

namespace FBN\GuideBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\RequestStack;
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
}
