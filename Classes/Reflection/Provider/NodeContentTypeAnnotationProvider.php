<?php

namespace Foo\ContentManagement\Reflection\Provider;

/* *
 * This script belongs to the FLOW3 framework.                            *
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

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 * Configurationprovider for the DummyAdapter
 *
 * @version $Id: YamlConfigurationProvider.php 3837 2010-02-22 15:17:24Z robert $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class NodeContentTypeAnnotationProvider extends AbstractAnnotationProvider {
	/**
	 * @var \TYPO3\FLOW3\Configuration\ConfigurationManager
	 * @FLOW3\Inject
	 */
	protected $configurationManager;

	/**
     * @FLOW3\Inject
     * @var \TYPO3\TYPO3CR\Domain\Service\ContentTypeManager
     */
    protected $contentTypeManager;

	public function getClassAnnotations($type){
		$contentTypes = $this->contentTypeManager->getFullConfiguration();

		$annotations = array();
		if(isset($contentTypes[$type])){
			foreach($contentTypes[$type] as $annotationName => $values){
				if($annotationName == "properties"){
					$properties = $values;
					$annotations["Properties"] = array();
					foreach ($properties as $property => $settings) {
						$propertyAnnotations = array();
						foreach ($settings as $annotationName => $values) {
							$annotationClass = $this->findAnnotationByName($annotationName);
							if($annotationClass){
								$values = $this->convert($values);
								$annotation = new $annotationClass($values);
								$this->addAnnotation($propertyAnnotations, $annotation);
							}
						}
						$annotations["Properties"][$property] = $propertyAnnotations;
					}
				} else {
					$annotationClass = $this->findAnnotationByName($annotationName);
					if($annotationClass){
						$values = $this->convert($values);
						$annotation = new $annotationClass($values);
						$this->addAnnotation($annotations, $annotation);
					}
				}
			}
		}

		return $annotations;

		$classes = $this->configurationManager->getConfiguration(\TYPO3\FLOW3\Configuration\ConfigurationManager::CONFIGURATION_TYPE_SETTINGS, "Foo.ContentManagement.Annotations");

		$annotations = array();

		if(isset($classes[$class])){
			foreach ($classes[$class] as $annotationName => $values) {
				if($annotationName == "Properties"){
					$properties = $values;
					$annotations["Properties"] = array();
					foreach ($properties as $property => $settings) {
						if($property == "FLOW3_Persistence_Identifier") continue;
						$propertyAnnotations = array();
						foreach ($settings as $annotationName => $values) {
							$annotationClass = $this->findAnnotationByName($annotationName);
							$values = $this->convert($values);
							$annotation = new $annotationClass($values);
							$this->addAnnotation($propertyAnnotations, $annotation);
						}
						$annotations["Properties"][$property] = $propertyAnnotations;
					}
				} else {
					$annotationClass = $this->findAnnotationByName($annotationName);
					$values = $this->convert($values);
					$annotation = new $annotationClass($values);
					$this->addAnnotation($annotations, $annotation);
				}
			}
		}
		
		return $annotations;
	}

	public function convert($input){
		if(is_array($input)){
			return $input;
		} else {
			return array( "value" => $input );
		}
	}
}
?>