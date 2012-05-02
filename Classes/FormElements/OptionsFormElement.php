<?php
namespace Foo\ContentManagement\FormElements;

/*                                                                        *
 * This script belongs to the FLOW3 package "TYPO3.Form".                 *
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
class OptionsFormElement extends ComplexFormElement {
	/**
	 * @var \Foo\ContentManagement\Adapters\ContentManager
	 * @FLOW3\Inject
	 */
	protected $contentManager;	

	public function getProperties() {
		$optionsProvider = $this->getOptionsProvider();
		$this->properties["options"] = $this->getOptionsProvider()->getOptions();
		return $this->properties;
	}

	public function getOptionsProvider() {
		$optionsProviderClass = $this->getAnnotations()->getOptionsProvider();
		$optionsProvider = new $optionsProviderClass($this->getAnnotations());
		return $optionsProvider;
	}

	public function getAnnotations() {
		return $this->properties["annotations"];
	}
}
?>