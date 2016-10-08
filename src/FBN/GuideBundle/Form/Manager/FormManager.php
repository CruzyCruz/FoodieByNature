<?php

namespace FBN\GuideBundle\Form\Manager;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;

class FormManager
{
    /**
     * @var string
     */
    private $defaultLocale;

    public function __construct($defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * Disable non translatable form fields for non default locale.
     *
     * @param FormBuilderInterface $formBuilder
     * @param array                $fieldsToBeDisabled
     * @param string               $currentLocale
     */
    public function disableNonTranslatableFormFieldsForNonDefaultLocale(FormBuilderInterface $formBuilder, $fieldsToBeDisabled, $currentLocale)
    {
        if ($currentLocale !== $this->defaultLocale) {
            foreach ($fieldsToBeDisabled as $field) {
                $formBuilder->get($field)->setDisabled(true);
            }
        }
    }

    public function isFileFieldRequired(Request $masterRequest)
    {
        $action = $masterRequest->query->get('action');

        if ($action === 'edit') {
            return false;
        }

        return true;
    }
}
