Additional Features
###################

MagicModel
**********
You can extend your Models from this Model to get Magic Getters, Setters and some other features.
Be aware of the fact that you should implement your Getters and Setters sooner or later to gain some Performance. 
But for development stage it just keeps the FLOW when you don't need to bother about all those repetative getters and setters all
the time.
> Note: This Exposeistration interface works completely without this MagicModel. You just need to make sure, that you have all
the getter and setter functions properly defined in your models. Additionally it is strongly suggested to implement
the __toString funtion for your Models to return a sensible String representation of the Model.

getPropertyName()
    tries to get the property

setPropertyName($value)
    tries to set the property

addPropertyName($item)
    add an item to an collection

hasPropertyName($item)
    checks if the collection contains that item

removePropertyName($item)
    removes the item from the collection

__toString()
    returns an smart string representation of the Model

toArray()
    dumps the models properties to an array

fromArray($values)
    sets the models properties based on the supplied values

Navigation
**********

Adding by Annotation
====================

Through the NavigationAnnotation you have the ability to add any number of ControllerActions to the global Expose Navigations

title
    specifies the Title for the NavigationItem

position
    specifies the Position where this NavigationItem should be shown (top, left)

priority
    specify an integer of the NavigationItem's priority, NavigationItems are sorted from highest to lowest

**Example**::

    use Expose\Annotations as Expose;
    class StandardController extends \TYPO3\FLOW3\Mvc\Controller\ActionController {
        /**
         * @return void
         * @Expose\Navigation(title="Overview", position="top", priority="10000")
         */
        public function indexAction() {
        }
    }


Adding by API
=============
Additionally to the Annotation method you can add items to the Navigation through the \Expose\Core\API::addNavigationItem($name, $position, $arguments, $priority).

name
    specifies the Title for the NavigationItem

position
    specifies the Position where this NavigationItem should be shown (top, left)

arguments
    arguments for the link to be generated

priority
    specify an integer of the NavigationItem's priority, NavigationItems are sorted from highest to lowest

> Note: Be aware of the fact, that NavigationItems added through this API aren't persisted and should only be used for the sidebar

***Example**::

    $arguments = array(
        "action" => "index",
        "controller" => "standard",
        "package" => "ExposeDemo"
    );
    \Expose\Core\API::addNavigationItem("MySidebarNavigationItem", "left", $arguments, 10);

Access Control
**************

Through the Access annotation you have the ability to protect your ControllerActions with the Expose UserAuthorization.

All you need to do is to add this Annotation to the Actions you wish to protect::

    /**
     * @Expose\Annotations\Access()
     */
    public function indexAction(){}

When you don't specifiy any parameters it will just check for a valid user and redirect to the login it no user is logged in.

Parameters
==========

expose
    set this to true in order to require an expose for this action

role
    set this to a specific role to require the user to be in this role. (Expose overrules this!)