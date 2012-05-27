<?php

namespace Foo\ContentManagement\Core\Adapters;

/*                                                                        *
 * This script belongs to the FLOW3 package "Contacts".                   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License as published by the Free   *
 * Software Foundation, either version 3 of the License, or (at your      *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        *
 * You should have received a copy of the GNU General Public License      *
 * along with the script.                                                 *
 * If not, see http://www.gnu.org/licenses/gpl.html                       *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Doctrine\ORM\Mapping as ORM;
use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * abstract base class for the Adapters
 *
 * @version $Id: AbstractValidator.php 3837 2010-02-22 15:17:24Z robert $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
abstract class AbstractAdapter implements \Foo\ContentManagement\Core\Adapters\AdapterInterface {
    /**
     * @var integer
     * @author Marc Neuhaus <apocalip@gmail.com>
     */
    protected $priority = 10;

	/**
	 * @var \Foo\ContentManagement\Reflection\AnnotationService
	 * @FLOW3\Inject
	 */
	protected $annotationService;
		
	/**
	 * @var TYPO3\FLOW3\Cache\CacheManager
	 * @FLOW3\Inject
	 */
	protected $cacheManager;
	
	/**
	 * @var \Foo\ContentManagement\Core\Helper
	 * @author Marc Neuhaus <apocalip@gmail.com>
	 * @FLOW3\Inject
	 */
	protected $helper;
	
	/**
	 * @var \TYPO3\FLOW3\Object\ObjectManagerInterface
	 * @api
	 * @author Marc Neuhaus <apocalip@gmail.com>
	 * @FLOW3\Inject
	 */
	protected $objectManager;
	
	/**
	 * @var \TYPO3\FLOW3\Package\PackageManagerInterface
	 * @author Marc Neuhaus <apocalip@gmail.com>
	 * @FLOW3\Inject
	 */
	protected $packageManager;
	
	/**
	 * @var TYPO3\FLOW3\Property\PropertyMapper
	 * @api
	 * @author Marc Neuhaus <apocalip@gmail.com>
	 * @FLOW3\Inject
	 */
	protected $propertyMapper;
	
	/**
	 * @var \TYPO3\FLOW3\Reflection\ReflectionService
	 * @api
	 * @author Marc Neuhaus <apocalip@gmail.com>
	 * @FLOW3\Inject
	 */
	protected $reflectionService;

	/**
	 * Initialize the Adapter
	 *
	 * @author Marc Neuhaus <mneuhaus@famelo.com>
	 * */
	public function init() {
		$this->settings = $this->helper->getSettings("Foo.ContentManagement");
	}
	
	public function getFilter($being,$selected = array()){
		$beings = $this->getBeings($being);
		$filters = array();
		foreach($beings as $being){
			$properties = $being->__properties;
			foreach($properties as $property){
				if($property->isFilter()){
					if(!isset($filters[$property->getName()]))
						$filters[$property->getName()] = new \Foo\ContentManagement\Core\Filter();

					if(isset($selected[$property->getName()]) && $selected[$property->getName()] == $property->getString()){
						$property->setSelected(true);
					}
					#$string = $property->getString();
					#if(!empty($string))
						$filters[$property->getName()]->addProperty($property);
				}
			}
		}
		return $filters;
	}

	public function isObjectPropertyGettable($object, $property) {
        return \TYPO3\FLOW3\Reflection\ObjectAccess::isPropertyGettable($object, $property);
    }

    public function getObjectProperty($object, $property) {
        return \TYPO3\FLOW3\Reflection\ObjectAccess::getProperty($object, $property);
    }

    public function getPriority() {
    	return $this->priority;
    }

    public function getType($object) {
    	return get_class($object);
    }
}

?>