Model Configuration
###################

Active
*********
Enable the Expose Interface for a Model

**Class Reflection**::

    use Expose\Annotations as Expose;
    /** A Blog post
      * ...
      * @Expose\Active 
      */
    class Post {...
        
**YAML**::

    TYPO3\Blog\Domain\Model\Post:
        Active: true

Group
*****
Specifiy a Group in which the Model will be Listed in the Menu. By Default the Models will be Sorted in Categories based on the Package name.

**Class Reflection**::

    use Expose\Annotations as Expose;
    /** A Blog post
      * ...
      * @Expose\Active
      * @Expose\Group("MyBlog")
      */
    class Post {...
        
**YAML**::

    TYPO3\Blog\Domain\Model\Post:
        Active: true
        Group: MyBlog

Label
*****
Specifiy a Label for the Model to be used in the Menu.

**Class Reflection**::

    use Expose\Annotations as Expose;
    /** A Blog post
      * ...
      * @Expose\Active
      * @Expose\Label("Blog Posts")
      */
    class Post {...

**YAML**::

    TYPO3\Blog\Domain\Model\Post:
        Active: true
        Label: Blog Posts

Set
***
By Default all [Properties](property) will be in a General Fieldset called General in the Order in which they are listed in the Models class. You can override this by specifiying specific Sets of fields.

**Class Reflection**::

    use Expose\Annotations as Expose;
    /** A Blog post
      * ...
      * @Expose\Active
      * @Expose\Annotations\Set(title="Main", properties="title,content")
      * @Expose\Annotations\Set(title="Extended Informations", properties="linkTitle,date,author,image")
      */
    class Post {...
        
**YAML**::

    TYPO3\Blog\Domain\Model\Post:
        Active: true
        Set: 
            - 
                Title: Main
                Properties: title, content
            -
                Title: Extended Informations
                Properties: linkTitle, date, author, image

Variant
*******
Variants are different Templates for actions. There are 3 Variants for the List Action included:

List
	The regular Pagniated Table
	
Panes
    Variant with 2 Panes like a E-Mail View

Calendar
    Very basic implementation for a calendar view

**Class Reflection**::

    use Expose\Annotations as Expose;
    /** A Blog post
      * ...
      * @Expose\Active
      * @Expose\Variant(variant="Calendar", options="Calendar, List")
      */
    class Event {...

**YAML**::

    Expose\Domain\Model\Event:
        Active: true
        Variant: 
            variant: Calendar
            options: Calendar, List
            
Options
-------

variant
    Name of the Variant

options
    List of Variants that should be selectable

VariantMappings
***************
VariantMappings are used in conjunction with Variants to tell the specific variant which property of the entity can be used for what

Panes
    image, title, subtitle, content

Calendar
    title, start, end

**Class Reflection**::

    use Expose\Annotations as Expose;
    /** A Blog post
      * ...
      * @Expose\Active
      * @Expose\Variant(variant="Calendar", options="Calendar, List")
      * @Expose\VariantMapping(title="title", start="startdate", end="enddate")
      */
    class Event {...

**YAML**::

    Expose\Domain\Model\Event:
        Active: true
        Variant: 
            variant: Calendar
            options: Calendar, List
        VariantMapping:
            title: title
            start: startdate
            end: enddate