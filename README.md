php-pagination
================

Класс постраничной навигации для любого PHP-проекта

## Installation and usage ##


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
			<td>Amount of records at page. <i>By default: 10</i>.</td>
		</tr>
		<tr>
			<td>pages_amount</td>
			<td>integer or string</td>
			<td>Amount of displaying pages on the right and on the left  from current page. <i>By default: 5</i>.</td>
		</tr>
		<tr>
			<td>where</td>
			<td>array</td>
			<td>Array of criterias for records selection. The parameter description is <a href="#the-parameter-of-criterias-where">here</a>. <i>No value by default</i>.</td>
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

## Methods of library ##

<table>
	<thead>
		<tr>
			<th>Method</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>buildPages()</td>
			<td>Generates group of pages. Uses in case if during initialization parameter “with_pages” did set as false.</td>
		</tr>
		<tr>
			<td>get()</td>
			<td>Returns pagination as an array of data.</td>
		</tr>
		<tr>
			<td>getCurrentPage()</td>
			<td>Returns number of current page.</td>
		</tr>
		<tr>
			<td>getLimit()</td>
			<td>Returns amount of records on page.</td>
		</tr>
		<tr>
			<td>getPagesAmount()</td>
			<td>Returns amount of pages, displaying on the right and on the left from current.</td>
		</tr>
		<tr>
			<td>getStart()</td>
			<td>Returns number of record, from which started show of page (numbering from zero).</td>
		</tr>
		<tr>
			<td>getTotalRecords()</td>
			<td>Returns total amount of records in table, considering criterias, if they did set.</td>
		</tr>
		<tr>
			<td>getTotalPages()</td>
			<td>Returns total amount of pages.</td>
		</tr>
		<tr>
			<td>getPages()</td>
			<td>Returns an array of current group of pages.</td>
		</tr>
		<tr>
			<td>getStartShow()</td>
			<td>Returns number of record, from which started show of page (numbering from one).</td>
		</tr>
		<tr>
			<td>getEndShow()</td>
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

Индекс массива навигации «pages» представляет собой массив, каждый элемент которого содержит объект <code>Page</code> со следующими методами:

<table>
	<thead>
		<tr>
			<th>Метод</th>
			<th>Тип возвращаемого заначения</th>
			<th>Описание</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>getCaption()</td>
			<td>string</td>
			<td>Возвращает надпись для ссылки на страницу.</td>
		</tr>
		<tr>
			<td>getNumber()</td>
			<td>integer</td>
			<td>Возвращает номер страницы.</td>
		</tr>
		<tr>
			<td>getHref()</td>
			<td>string</td>
			<td>Возвращает ссылку на страницу.</td>
		</tr>
		<tr>
            <td>isFirst()</td>
            <td>boolean</td>
            <td>Это ссылка на первую страницу.</td>
        </tr>
        <tr>
            <td>isPreviousGroup()</td>
            <td>boolean</td>
            <td>Это ссылка на предыдущую группу страниц.</td>
        </tr>
        <tr>
            <td>isPrevious()</td>
            <td>boolean</td>
            <td>Это ссылка на предыдущую страницу.</td>
        </tr>
        <tr>
            <td>isNumeric()</td>
            <td>boolean</td>
            <td>Это нумерованная ссылка на страницу.</td>
        </tr>
        <tr>
            <td>isCurrent()</td>
            <td>boolean</td>
            <td>Это ссылка на текущую страницу.</td>
        </tr>
        <tr>
            <td>isNext()</td>
            <td>boolean</td>
            <td>Это ссылка на следующую страницу.</td>
        </tr>
        <tr>
            <td>isNextGroup()</td>
            <td>boolean</td>
            <td>Это ссылка на следующую группу страниц.</td>
        </tr>
        <tr>
            <td>isLast()</td>
            <td>boolean</td>
            <td>Это ссылка на последнюю страницу.</td>
        </tr>
	</tbody>
</table>

## Послесловие ##

Пример вывода постраничной навигации с использованием Twig:

    {% if pagination %}
	    <div>Current page is {{ pagination.current_page }}</div>
	    <div>Showed from {{ pagination.start_show }} to {{ pagination.end_show }} - {{ pagination.limit }} items</div>
	    <div>Total {{ pagination.total_records }} items on {{ pagination.total_pages }} pages</div>
	    {% if pagination.pages %}
		    <ul class="pagination">
		    {% for page in pagination.pages %}
			    <li{{ page.is_current ? ' class="active"' : ''}}>
			    <a href="{{ page.href }}"{% for key,value in page.attributes %} {{ key }}="{{ value }}"{% endfor %}>{{ page.caption }}</a>
			    </li>
		    {% endfor %}
		    </ul>
	    {% endif %}
    {% endif %}
    