Pagination-Class
================

Pagination class for PHP (AJAX ready)

## Warning ##

Excuse my English. Original instruction written on Russian. I would be pleased, if anybody will translate it to correct English.

## Installation and usage ##

- Copy the file Pagination.class.php to project directory;

- Include the file there, when you want to use pagination (require_ince(‘path-to-class/Pagination.class.php’));

- Initialize class ($pagination = new Pagination($parameters)).

## Parameters of library ##

The parameters of library are an array with next indexes:

<table>
	<thead>
		<tr>
			<th>Index of array</th>
			<th>Type</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>db (*)</td>
			<td>PDO object</td>
			<td>PDO object for database connection. (Class work tested at MySQL and PostgreSQL connections.) <b>Required, if not indicated parameter db_config</b>.</td>
		</tr>
		<tr>
			<td>db_config (*)</td>
			<td>array</td>
			<td>Array of keys-parameters for database connection. The parameter description is <a href="#the-parameter-for-database-connection-db_config">here</a>. <b>Required, if not indicated parameter db</b>.</td>
		</tr>
		<tr>
			<td>table*</td>
			<td>string</td>
			<td>Table with needed records. <b>Required</b>.</td>
		</tr>
		<tr>
			<td>url*</td>
			<td>string</td>
			<td>URL to page, where displaying records (for example: http://yoursite.com/news, /news/ or /news.php?page=). <b>Required</b>.</td>
		</tr>
		<tr>
			<td>page</td>
			<td>integer</td>
			<td>Number of displaying page. <i>By default: 1</i>.</td>
		</tr>
		<tr>
			<td>limit</td>
			<td>integer</td>
			<td>Amount of records at page. May be indicate clearly - as number, or not clearly – as string, representing an index of configuration file, which store a value. <i>By default: 10</i>.</td>
		</tr>
		<tr>
			<td>pages_amount</td>
			<td>integer or string</td>
			<td>Amount of displaying pages on the right and on the left  from current page. May be indicate clearly - as number, or not clearly – as string, representing an index of configuration file, which store a value. <i>By default: 5</i>.</td>
		</tr>
		<tr>
			<td>where</td>
			<td>array</td>
			<td>Array of criterias for records selection (like for Codeigniter Active Record). <i>No value by default</i>.</td>
		</tr>
		<tr>
			<td>with_pages</td>
			<td>boolean</td>
			<td>Specifies whether to generate the pagination links. The parameter may be required in case if needed to display random page without possibility move on (for example, as free demonstration materials of the website). <i>By default: true</i>.</td>
		</tr>
		<tr>
			<td>except_first_last</td>
			<td>boolean</td>
			<td>If a parameter “with_pages” set as true, then this can except link to first and last pages. <i>By default: false</i>.</td>
		</tr>
		<tr>
			<td>except_groups</td>
			<td>boolean</td>
			<td>If a parameter “with_pages” set as true, then this can except link to next and previous groups of pages. Group is set of current page and displaying pages on the left and on the right. <i>By default: false</i>.</td>
		</tr>
		<tr>
			<td>except_next_previous</td>
			<td>boolean</td>
			<td>If a parameter “with_pages” set as true, then this can except link to next and previous pages. <i>By default: false</i></>.</td>
		</tr>
		<tr>
			<td>except_numeric</td>
			<td>boolean</td>
			<td>If a parameter “with_pages” set as true, then this can except link to numeric pages. <i>By default: false</i>.</td>
		</tr>
		<tr>
			<td>label_first</td>
			<td>string</td>
			<td>Label for a link to first page. <i>By default: <<<</i>.</td>
		</tr>
		<tr>
			<td>label_last</td>
			<td>string</td>
			<td>Label for a link to last page. <i>By default: >>></i>.</td>
		</tr>
		<tr>
			<td>label_next_group</td>
			<td>string</td>
			<td>Label for a link to next group of pages. <i>By default: >></i>.</td>
		</tr>
		<tr>
			<td>label_previous_group</td>
			<td>string</td>
			<td>Label for a link to previous group of pages. <i>By default: <<</i>.</td>
		</tr>
		<tr>
			<td>label_next</td>
			<td>string</td>
			<td>Label for a link to next page. <i>By default: ></i>.</td>
		</tr>
		<tr>
			<td>label_previous</td>
			<td>string</td>
			<td>Label for a link to previous page. <i>By default: <</i>.</td>
		</tr>
		<tr>
			<td>pages_attributes</td>
			<td>array</td>
			<td>Array of attributes for navigation links. May include any html-attributes, for example: id, class, data-attributes. The parameter description is <a href="#the-parameter-of-attributes-for-navigation-links-pages_attributes">here</a>. <i>No value by default</i>.</td>
		</tr>
	</tbody>
</table>

## The parameter for database connection (db_config) ##

This parameter contains next indexes:

<table>
	<thead>
		<tr>
			<th>Index of array</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>host *</td>
			<td>DBMS host.</td>
		</tr>
		<tr>
			<td>database *</td>
			<td>Database name.</td>
		</tr>
		<tr>
			<td>user *</td>
			<td>User name.</td>
		</tr>
		<tr>
			<td>password *</td>
			<td>User password.</td>
		</tr>
		<tr>
			<td>driver</td>
			<td>DBMS driver. <i>By default: mysql</i>.</td>
		</tr>
		<tr>
			<td>port</td>
			<td>DBMS port. <i>No value by default</i>.</td>
		</tr>
	</tbody>
</table>

## The parameter of attributes for navigation links (pages_attributes) ##

This parameter involves indexes of types pages with an array of the form: ‘html-attribute’ => ‘value of attribute’.

Types of pages:

<table>
	<thead>
		<tr>
			<th>Index of array</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>first</td>
			<td>For a link to first page.</td>
		</tr>
		<tr>
			<td>previous_group</td>
			<td>For a link to previous group of pages.</td>
		</tr>
		<tr>
			<td>previous</td>
			<td>For a link to previous page.</td>
		</tr>
		<tr>
			<td>numeric</td>
			<td>For a link to numeric pages.</td>
		</tr>
		<tr>
			<td>current</td>
			<td>For a link to current page. For this type of page will be appended parameters for numeric pages, if it exists.</td>
		</tr>
		<tr>
			<td>next</td>
			<td>For a link to next page.</td>
		</tr>
		<tr>
			<td>next_group</td>
			<td>For a link to next group of pages.</td>
		</tr>
		<tr>
			<td>last</td>
			<td>For a link to last page.</td>
		</tr>
	</tbody>
</table>

Example:

    $parameters['pages_attributes'] = array(
	    'first' => array(
		    ‘id’ => ‘pagination-first’
		    'data-first' => 1
	    ),
	    'numeric' => array(
	    	'class’ => 'pagination-numeric'
	    )
    )

## Methods of library ##

For initialization library needed to call one of two methods: get($parameters) or build($parameters). After that you can use other methods.

<table>
	<thead>
		<tr>
			<th>Method</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>build_pages()</td>
			<td>Generates group of pages. Uses in case if during initialization parameter “with_pages” did set as false.</td>
		</tr>
		<tr>
			<td>get()</td>
			<td>Returns pagination as an array of data.</td>
		</tr>
		<tr>
			<td>get_current_page()</td>
			<td>Returns number of current page.</td>
		</tr>
		<tr>
			<td>get_limit()</td>
			<td>Returns amount of records on page.</td>
		</tr>
		<tr>
			<td>get_pages_amount()</td>
			<td>Returns amount of pages, displaying on the right and on the left from current.</td>
		</tr>
		<tr>
			<td>get_start()</td>
			<td>Returns number of record, from which started show of page (numbering from zero).</td>
		</tr>
		<tr>
			<td>get_total_records()</td>
			<td>Returns total amount of records in table, considering criterias, if they did set.</td>
		</tr>
		<tr>
			<td>get_total_pages()</td>
			<td>Returns total amount of pages.</td>
		</tr>
		<tr>
			<td>get_pages()</td>
			<td>Returns an array of current group of pages.</td>
		</tr>
		<tr>
			<td>get_pagination()</td>
			<td>Returns pagination as an array of data.</td>
		</tr>
		<tr>
			<td>get_start_show()</td>
			<td>Returns number of record, from which started show of page (numbering from one).</td>
		</tr>
		<tr>
			<td>get_end_show()</td>
			<td>Returns number of last displayed record.</td>
		</tr>
	</tbody>
</table>

## Array of pagination data ##

Array of pagination data contains next indexes:

<table>
	<thead>
		<tr>
			<th>Index</th>
			<th>Contains</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>current_page</td>
			<td>Contains number of current page.</td>
		</tr>
		<tr>
			<td>start</td>
			<td>Contains number of record, from which started show of page (numbering from zero).</td>
		</tr>
		<tr>
			<td>limit</td>
			<td>Contains amount of records on page.</td>
		</tr>
		<tr>
			<td>start_show</td>
			<td>Contains number of record, from which started show of page (numbering from one).</td>
		</tr>
		<tr>
			<td>end_show</td>
			<td>Contains number of last displayed record.</td>
		</tr>
		<tr>
			<td>total_records</td>
			<td>Contains total amount of records in table, considering criterias, if they did set.</td>
		</tr>
		<tr>
			<td>total_pages</td>
			<td>Contains total amount of pages.</td>
		</tr>
		<tr>
			<td>pages</td>
			<td>Contains an array of current group of pages.</td>
		</tr>
	</tbody>
</table>

## Array of pages group ##

Index of pagination array “pages” is array, each element contains next indexes:

<table>
	<thead>
		<tr>
			<th>Index</th>
			<th>Contains</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>caption</td>
			<td>Contains caption for link to page</td>
		</tr>
		<tr>
			<td>href</td>
			<td>Contains link to page.</td>
		</tr>
		<tr>
			<td>attributes</td>
			<td>Contains array of html-attributes</td>
		</tr>
	</tbody>
</table>

Also each page contains additional index, defining type of it.

<table>
	<thead>
		<tr>
			<th>Index</th>
			<th>Means</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>is_first</td>
			<td>This is link to first page.</td>
		</tr>
		<tr>
			<td>is_previous_group</td>
			<td>This is link to previous pages group.</td>
		</tr>
		<tr>
			<td>is_previous</td>
			<td>This is link to previous page.</td>
		</tr>
		<tr>
			<td>is_numeric</td>
			<td>This is numeric link to page.</td>
		</tr>
		<tr>
			<td>is_current</td>
			<td>This is link to current page. This type same contains index “is_numeric”.</td>
		</tr>
		<tr>
			<td>is_next</td>
			<td>This is link to next page.</td>
		</tr>
		<tr>
			<td>is_next_group</td>
			<td>This is link to next pages group.</td>
		</tr>
		<tr>
			<td>is_last</td>
			<td>This is link to last page.</td>
		</tr>
	</tbody>
</table>

## Afterword ##

Example displaying pagination, using Twig:

    {% if pagination %}
	    <div>Current page is {{ pagination.current_page }}</div>
	    <div>Showed from {{ pagination.start_show }} to {{ pagination.end_show }} - {{ pagination.limit }} items</div>
	    <div>Total {{ pagination.total_records }} items on {{ pagination.total_pages }} pages</div>
	    {% if pagination.pages %}
		    <ul class="pagination float-group">
		    {% for page in pagination.pages %}
			    <li{{ page.is_current ? ' class="active"' : ''}}>
			    <a href="{{ page.href }}"{% for key,value in page.attributes %} {{ key }}="{{ value }}"{% endfor %}>{{ page.caption }}</a>
			    </li>
		    {% endfor %}
		    </ul>
	    {% endif %}
    {% endif %}

[Here](https://github.com/barinbritva/Pagination-Codeigniter) you can learn how to easy make AJAX pagination and see a demo.