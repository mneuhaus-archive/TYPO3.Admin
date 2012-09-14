ViewHelpers
###########

ApiViewHelper
*************

This ViewHelper provides access to the \Expose\Core\API:: functions.

get
	specifies the variable or function to trigger on the API

as
	specifies the variable which will contain the result


BeingViewHelper
********************
This ViewHelper converts an regular Object to a so called Being with all Annotations, properties etc

class
	class to construct a being from

object
	object to construct a being from


DashboardWidgets
****************
This ViewHelper renders the currently active Widgets.


Form.FieldViewHelper
********************
This ViewHelper renders a form field with error handling, label infotext, etc

property
	the beings property to render

Example::

    <f:form method="post" action="form" fieldNamePrefix="form">
        <a:being className="ExposeDemo\Domain\Model\Address" as="being">
            <a:form.field being="{ being.street}" />
            <a:form.field being="{ being.housenumber}" />
            <a:form.field being="{ being.city}" />
        </a:being>
    </f:form>


Form.FieldsViewHelper
********************
This ViewHelper renders a form for a being. This ViewHelper doesn't render the form tag itself!

being
	being to render the form for

Example::

    <f:form method="post" action="form" fieldNamePrefix="form">
        <a:being className="ExposeDemo\Domain\Model\Address" as="being">
            <a:form.fields being="{ being}" />
        </a:being>
    </f:form>


LayoutViewHelper
****************
This ViewHelper extends the regular LayoutViewHelper with the ability to specifiy an package to search for the layout

name
	name of the layout

package
	name of the package to look for the layout
	
Example::
    
    <a:layout name="Bootstrap" package="Expose"/>


NavigationViewHelper
********************
Helps by rendering previously registered Navigation Items

position
	specifies the region of this navigation (top, left, ...)

as
	specifies the variable which will contain the navigation items
	
Example::

    <ul>
    <a:navigation position="top" as="navItem">
        <li><a href="{ navItem.link}">{ navItem.name}</a></li>
    </a:navigation>
    </ul>


Query.FilterViewHelper
********************
This ViewHelper can be used to filter objects

objects
    the objects that should be sorted

as
    variable for the filtered objects. By Default: filteredObjects

filtersAs
    variable for the filters. By Default: filters

Example::

    <a:query.filter objects="{ objects}">
        <f:for each="{ filteredObjects}" as="object">
            ...
        </f:for>
        <a:render partial="Filters/Right" fallbacks="Partials"/>
    </a:query.paginate>


Query.PaginationViewHelper
********************
This is a simple pagination ViewHelper to limit and paginate objects

objects
    the objects that should be paginated
    
as
    variable for the paginated objects. By Default: paginatedObjects

limitsAs
    variable for the limits. By Default: limits

paginationAs
    variable for the pagination. By Default: pagination
    
Example::

    <a:query.paginate objects="{ objects}">
        <f:for each="{ paginatedObjects}" as="object">
            ...
        </f:for>

        <div class="pagination pull-left">
            <a:render partial="Limits" fallbacks="Partials"/>
        </div>
        
        <div class="pagination pull-right">
            <a:render partial="Pagination" fallbacks="Partials"/>
        </div>
    </a:query.paginate>


Query.SearchViewHelper
**********************
This ViewHelper can be used to filter Objects by searching

objects
    the objects that should be filtered

as
    variable for the matching objects. By Default: matchingObjects

searchAs
    variable for the searchWord. By Default: search

Example::

    <a:query.search objects="{ objects}">
		<input type="text" class="" name="search" value="{search}" />
	    <button type="submit" class="btn">Search</button>

        <f:for each="{ matchingObjects}" as="object">
            ...
        </f:for>
    </a:query.paginate>


Query.SortViewHelper
********************
This ViewHelper can be used to sort objects

objects
    the objects that should be sorted

as
    variable for the sorted objects. By Default: sortedObjects

sortingAs
    variable for the sorting. By Default: sorting

Example::

    <a:query.sort objects="{ objects}">
        <f:link.action addQueryString="true" arguments="{sort: 'title', direction: sorting.oppositeDirection">
            Sort by title
        </f:link.action>
        <f:for each="{ sortedObjects}" as="object">
            ...
        </f:for>
    </a:query.paginate>


RenderViewHelper
****************
This ViewHelper extends the regular RenderViewHelper with these features:

optional
    you can set the optional parameter to true in conjunction with the section attribute. In contrast to the regular RenderViewHelper this one renders it's childs if the section isn't overidden instead of an empty string

fallbacks
	with this function you can specify an fallback path from the settings to search for the partial in conjunction with the vars parameter

Examples(Partial)::
    
    <a:render partial="Pagination" fallbacks="Partials"/>

Examples(Section)::
    
    <a:render section='container' optional="true">
        Content to be rendered when this section isn't overidden
    </a:render>


SettingsViewHelper
******************
This ViewHelper gives you access to global Settings from the view

path
	specifies the path to the setting
	
as
	if you specify this argument the content of that setting will be available as this variable inside the settings tag
	

UserViewHelper
**************
This ViewHelper gives you access to the current user

as
	specifies the variable which will contain the user