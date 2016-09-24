<?php

namespace FBN\GuideBundle\Translation;

use Symfony\Component\Form\FormBuilderInterface;

class TranslationManager
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
}
