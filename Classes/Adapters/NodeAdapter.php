<?php
namespace Foo\ContentManagement\Adapters;

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
 * Adapter for the Doctrine engine
 *
 * @version $Id: AbstractValidator.php 3837 2010-02-22 15:17:24Z robert $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 * @FLOW3\Scope("singleton")
 */
class NodeAdapter extends \Foo\ContentManagement\Core\Adapters\AbstractAdapter {
    /**
     * @var \TYPO3\FLOW3\Persistence\PersistenceManagerInterface
     * @author Marc Neuhaus <apocalip@gmail.com>
     * @FLOW3\Inject
     */
    protected $persistenceManager;

    /**
     * @FLOW3\Inject
     * @var \TYPO3\FLOW3\Validation\ValidatorResolver
     */
    protected $validatorResolver;

    /**
     * @var \TYPO3\FLOW3\Reflection\ReflectionService
     * @api
     * @author Marc Neuhaus <apocalip@gmail.com>
     * @FLOW3\Inject
     */
    protected $reflectionService;

    /**
     * @FLOW3\Inject
     * @var \TYPO3\TYPO3CR\Domain\Repository\NodeRepository
     */
    protected $nodeRepository;

    /**
     * @FLOW3\Inject
     * @var \TYPO3\TYPO3CR\Domain\Service\ContentTypeManager
     */
    protected $contentTypeManager;

    /**
     * apply filters
     *
     * @param string $beings
     * @param string $filters
     * @return void
     * @author Marc Neuhaus
     */
    public function applyFilters($beings, $filters) {
    }

    public function applyLimit($limit) {
        $this->query->setLimit($limit);
    }

    public function applyOffset($offset) {
        $this->query->setOffset($offset);
    }

    public function applyOrderings($property, $direction = null) {
        if (is_null($direction)) {
            $direction = \TYPO3\FLOW3\Persistence\QueryInterface::ORDER_ASCENDING;
        }

        $this->query->setOrderings(array(
            $property => $direction
        ));
    }

    public function getName($being) {
        return ucfirst($being);
    }

    public function initQuery($being) {
        $this->query = $this->nodeRepository->createQuery();
        $this->query->matching($this->query->equals('contentType', $being));
    }

    public function getClasses(){
        return array_keys($this->contentTypeManager->getFullConfiguration());
    }

    public function getGroups() {
        $this->init();
        $groups = array();

        $contentTypes = $this->contentTypeManager->getFullConfiguration();
        foreach ($contentTypes as $contentType => $packageName) {
            $annotations = $this->annotationService->getClassAnnotations($contentType);
            if(!$annotations->has("active")) continue;
            
            $group = "Nodes";
            $name = \Foo\ContentManagement\Core\Helper::getShortName($contentType);

            if ($annotations->has("group"))
                $group = (string) $annotations->get("group");

            if ($annotations->has("label"))
                $name = strval($annotations->get("label"));

            $groups[$group][] = array("being" => $contentType, "name" => $name);
        }
        return $groups;
    }

    public function getObject($being, $id = null) {
        if (true) {
            if ($id == null) {
                $node = new \TYPO3\TYPO3CR\Domain\Model\Node();
                $node->setContentType($being);
                return $node;
            } else {
                return $this->persistenceManager->getObjectByIdentifier($id, "\TYPO3\TYPO3CR\Domain\Model\Node");
            }
        }
        return null;
    }

    public function getObjects($class) {
        $annotations = $this->annotationService->getClassAnnotations($class);
        $objects = array();

        if (!isset($this->query) || !is_subclass_of($class, $this->repository->getEntityClassName()))
            $this->initQuery($class);
    
        if(isset($this->query) && is_object($this->query))
            $objects = $this->query->execute();

        return $objects;
    }

    public function getId($object) {
        if (is_object($object)) {
            return $this->persistenceManager->getIdentifierByObject($object);
        }
        return null;
    }

    public function isObjectPropertyGettable($object, $property) {
        return true;
    }

    public function getObjectProperty($object, $property) {
        return $object->getProperty($property);
    }

    public function getQuery() {
        return $this->query;
    }

    public function getRepositoryForModel($model) {
        $annotations = $this->annotationService->getClassAnnotations($model);
        $classSchema = $this->reflectionService->getClassSchema($model);

        $repository = $classSchema->getRepositoryClassName();
        return $repository;
    }

    public function getTotal($being) {
        return $this->query->count();
    }

    public function isNewObject($object) {
        return $this->persistenceManager->isNewObject($object);
    }

    public function createObject($being, $data) {
        $configuration = $this->annotationService->getClassAnnotations($being);
        $result = $this->transform($data, $being);

        if (is_a($result, $being)) {
            $repository = $this->objectManager->get($this->getRepositoryForModel($being));
            $repository->add($result);
            $this->persistenceManager->persistAll();
        }
        return $result;
    }

    public function updateObject($being, $id, $data) {
        $configuration = $this->annotationService->getClassAnnotations($being);
        $result = $this->transform($data, $being);

        if (is_a($result, $being)) {
            $repository = $this->objectManager->get($this->getRepositoryForModel($being));
            $repository->update($result);
            $this->persistenceManager->persistAll();
        }
        return $result;
    }

    public function deleteObject($being, $id) {
        $object = $this->persistenceManager->getObjectByIdentifier($id, $being);
        if ($object == null) return;
        $repositoryObject = $this->objectManager->get($this->getRepositoryForModel($being));
        $repositoryObject->remove($object);
        $this->persistenceManager->persistAll();
    }

    ## Conversion Functions

    public function transform($data, $target) {
        return $data;
    }
}

?>