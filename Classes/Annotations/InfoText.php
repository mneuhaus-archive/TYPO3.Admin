<?php
namespace TYPO3\Expose\Annotations;

/*                                                                        *
 * This script belongs to the TYPO3.Expose package.              *
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
final class InfoText {

    /**
     * @var string
     */
    public $text = '';

    /**
     * @param string $value
     */
    public function __construct(array $values) {
        if (isset($values['value'])) {
            $this->text = $values['value'];
        }
    }

    /**
    * TODO: Document this Method! ( __toString )
    */
    public function __toString() {
        return $this->text;
    }

}

?>