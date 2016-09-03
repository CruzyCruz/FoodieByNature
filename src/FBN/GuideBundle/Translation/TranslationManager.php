<?php

namespace FBN\GuideBundle\Translation;

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

    public function disableNonTranslatableFormFieldsForNonDefaultLocale($formBuilder, $fieldsToBeDisabled, $currentLocale)
    {
        if ($currentLocale !== $this->defaultLocale) {
            foreach ($fieldsToBeDisabled as $field) {
                $formBuilder->get($field)->setDisabled(true);
            }
        }
    }
}
