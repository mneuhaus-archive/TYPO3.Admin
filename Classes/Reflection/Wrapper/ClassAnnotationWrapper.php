<?php
namespace Foo\ContentManagement\Reflection\Wrapper;

/*                                                                        *
 * This script belongs to the FLOW3 framework.                            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 */
class ClassAnnotationWrapper extends AbstractAnnotationWrapper {
	public function getPropertyAnnotations($propertyName) {
		$properties = $this->get("Properties");
		$property = new \Foo\ContentManagement\Reflection\Wrapper\PropertyAnnotationWrapper($properties[$propertyName]);
		$property->setProperty($propertyName);
		$property->setClass($this->getClass());
		
		if($this->has("Object")){
			$adapter = $this->contentManager->getAdapterByClass($this->getClass());
			if($adapter->isObjectPropertyGettable($this->get("Object"), $propertyName))
				$property->setValue($adapter->getObjectProperty($this->get("Object"), $propertyName));
		}
		return $property;
	}

	public function getProperties($context = null) {
		$properties = array();
		foreach ($this->get("properties") as $property => $value) {
			$properties[$property] = $this->getPropertyAnnotations($property);

			if(!is_null($context) 
				&& $properties[$property]->has("ignore")
				&& $properties[$property]->getIgnore()->ignoreContext($context))
				unset($properties[$property]);
		}
		return $properties;
	}

	public function getSets() {
		return array("" => $this->getProperties());
	}
}

?>