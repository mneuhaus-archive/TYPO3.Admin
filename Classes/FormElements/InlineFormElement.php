<?php
namespace TYPO3\Admin\FormElements;

/*                                                                        *
 * This script belongs to the TYPO3.Admin package.              *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * A generic form element
 */
class InlineFormElement extends \TYPO3\Form\FormElements\Section {

    /**
     *
     * @var object
     **/
    protected $annotations;

    /**
     *
     * @var object
     **/
    protected $formBuilder;

    /**
     * Default Value of this Section
     *
     * @var mixed
     */
    protected $defaultValue = NULL;

    /**
    * TODO: Document this Method! ( getAnnotations )
    */
    public function getAnnotations() {
        return $this->annotations;
    }

    /**
    * TODO: Document this Method! ( setAnnotations )
    */
    public function setAnnotations($annotations) {
        $this->annotations = $annotations;
    }

    /**
    * TODO: Document this Method! ( getMultipleMode )
    */
    public function isMultipleMode() {
        if ($this->annotations->has("Doctrine\ORM\Mapping\ManyToMany") || $this->annotations->has("Doctrine\ORM\Mapping\OneToMany")){
            return TRUE;
        } else {
            return TRUE;
        }
    }

    public function setFormBuilder($formBuilder) {
        $this->formBuilder = $formBuilder;
    }

    /**
    * TODO: Document this Method! ( getNextKey )
    */
    public function getNextKey() {
        return count($this->getElements()) + 1;
    }


    /**
     * Set the default value with which the Form Element should be initialized
     * during display.
     *
     * @param mixed $defaultValue the default value for this Form Element
     * @api
     */
    public function setDefaultValue($defaultValue) {
        $this->defaultValue = $defaultValue;

        $value = $this->getValue();
        if ($value !== NULL) {
            $namespace = $this->getIdentifier();
            if ($this->isMultipleMode()){
                $inlineVariant = $this->annotations->getInline()->getVariant();
                $containerSection = $this->createElement('container.' . $namespace, $inlineVariant . 'Item');
                $containerSection->setAnnotations($this->annotations);
                foreach ($value as $key => $object) {
                    $section = $this->formBuilder->createElementsForSection(count($this->renderables), $containerSection, $namespace . "." . $key, $object);
                    $this->formBuilder->loadDefaultValuesIntoForm($this->getRootForm(), $object, $namespace . "." . $key);
                }
            } else {

            }
        }
    }

    public function getValue() {
        if ($this->defaultValue == NULL) {
            $class = $this->annotations->getType();
            return new $class();
        }
        return $this->defaultValue;
    }

    /**
    * TODO: Document this Method! ( getPropertyNames )
    */
    public function getPropertyNames() {
        $propertyNames = array();
        foreach ($this->getAnnotations()->getProperties() as $property) {
            $propertyNames[] = $property->getLabel();
        }
        return $propertyNames;
    }

    /**
    * TODO: Document this Method! ( getTemplate )
    */
    public function getTemplate() {
        $class = $this->annotations->getType();
        $object = new $class();
        $namespace = '_template.' . $this->getIdentifier() . '.000';
        $parentSection = clone $this;
        $containerSection = $parentSection->createElement('container.' . $namespace, 'TYPO3.Form:Section');
        $section = $this->formBuilder->createFormForSingleObject($containerSection, $object, $namespace);
        $containerSection->setDataType($class);
        return $containerSection;
    }

    /**
    * TODO: Document this Method! ( getUnusedElement )
    */
    public function getUnusedElement($key = 0) {
        $class = $this->annotations->getType();
        $object = new $class();
        $namespace = $this->getIdentifier();
        if($this->isMultipleMode()){
            $namespace.= "." . $key;
        }
        $inlineVariant = $this->annotations->getInline()->getVariant();
        $containerSection = $this->createElement('container.' . $namespace, $inlineVariant . 'Item');
        $containerSection->setAnnotations($this->annotations);
        $section = $this->formBuilder->createElementsForSection(count($this->renderables), $containerSection, $namespace, $object);
        return $containerSection;
    }

    public function getElements() {
        $elements = parent::getElements();

        if (empty($elements)) {
            $elements[] = $this->getUnusedElement();
        }

        return $elements;
    }
}

?>