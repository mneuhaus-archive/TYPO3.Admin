<?php
namespace TYPO3\Admin\Controller;

/* *
 * This script belongs to the TYPO3.Admin package.              *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Doctrine\ORM\Mapping as ORM;
use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Action to create a new Being
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class NewController extends \TYPO3\Admin\Core\AbstractAdminController {

	/**
	 * Create a new object
	 *
	 * @param string $type
	 */
	public function indexAction($type) {
		$objects = array(new $type());
		$this->view->assign('className', $type);
		$this->view->assign('objects', $objects);
		$this->view->assign('callback', 'create');
	}

	/**
	 * @param string $type
	 */
	public function createAction($type) {
		$objects = $this->request->getInternalArgument("__objects");
		foreach ($objects as $object) {
			$this->persistenceManager->add($object);
		}
		$this->redirect('index', 'sametypelist', 'TYPO3.Admin', array('type' => $type));
	}

}

?>