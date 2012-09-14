<?php
namespace TYPO3\Expose\Core;

/*                                                                        *
 * This script belongs to the TYPO3.Expose package.              *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;
use TYPO3\FLOW3\Mvc\ActionRequest;

/**
 * Runtime for expose controllers
 *
 * // REVIEWED for release.
 */
class ExposeRuntime extends AbstractRuntime {

    /**
     * Default action to render if nothing else is specified
     * or present in the arguments
     *
     * @var string
     * @internal
     */
    protected $defaultExposeControllerClassName = 'TYPO3\\Expose\\Controller\\IndexController';

    /**
     *
     * @var string
     */
    protected $namespace = 'exposeRuntime';
}
?>