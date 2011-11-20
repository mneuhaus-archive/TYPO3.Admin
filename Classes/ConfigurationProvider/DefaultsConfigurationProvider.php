<?php

namespace Admin\ConfigurationProvider;

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

/**
 * ConfigurationProvider to add default configurations from yaml
 *
 * @version $Id: YamlConfigurationProvider.php 3837 2010-02-22 15:17:24Z robert $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class DefaultsConfigurationProvider extends \Admin\Core\ConfigurationProvider\AbstractConfigurationProvider {

	public function get($being){
		$c = array();

		$settings = $this->helper->getSettings("Admin");
		
		if(isset($settings["Defaults"])){
			$c = $settings["Defaults"];
			unset($c["properties"]);
			$propertyDefaults = $settings["Defaults"]["properties"];
			
			if( class_exists($being, false) ) {
				$properties = $this->helper->getModelProperties($being);
				foreach($properties as $property => $conf){
					$c["properties"][$property] = $propertyDefaults;
				}
			}
			
		}

		return $c;
	}

}
?>