<?php
namespace Foo\ContentManagement\Annotations;

/*                                                                        *
 * This script belongs to the FLOW3 framework.                            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @Annotation
 */
final class Label implements SingleAnnotationInterface {
	/**
	 * @var string
	 */
	public $name = '';

	/**
	 * @param string $value
	 */
	public function __construct(array $values) {
		if (isset($values['value'])) {
			$this->name = $values['value'];
		}
	}
	
	public function __toString(){
		return $this->name;
	}
}

?>