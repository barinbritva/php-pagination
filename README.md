php-pagination
================

Библиотека постраничной навигации для любого PHP-проекта.

# Установка #

<code>composer require barinbritva/pagination</code>

# Минимальный пример использования #

// todo описание использования

## Пример вывода постраничной навигации с использованием Twig: ##

    {% if pagination.pages %}
	    <div>Текущая страница {{ pagination.currentPage }}</div>
	    <div>Показано с {{ pagination.startShow }} по {{ pagination.endShow }}</div>
	    <div>Всего {{ pagination.totalRecords }} записей на {{ pagination.totalPages }} страницах</div>
            <ul class="pagination">
            {% for page in pagination.pages %}
                <li{{ page.isCurrent ? ' class="active"' : ''}}>
                <a href="{{ page.href }}">{{ page.label }}</a>
                </li>
            {% endfor %}
            </ul>
    {% endif %}

# API #

## Методы библиотеки ##

<table>
	<thead>
		<tr>
			<th>Метод</th>
			<th>Аргументы</th>
			<th>Описание</th>
			<th>Возвращаемое значение</th>
		</tr>
	</thead>
	<tbody>
	<tr>
        <td>setUrl($url)</td>
        <td>$url: string</td>
        <td>Установить ссылку на страницу, где происходит вывод записей (например: http://yoursite.com/news, /news/ или /news.php?page=).</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>getUrl()</td>
        <td>-</td>
        <td>Получить ссылку на страницу, где происходит вывод записей.</td>
        <td>string</td>
    </tr>
    <tr>
        <td>setPageLimit($limit)</td>
        <td>$limit: integer</td>
        <td>Установить количество видимых ссылок справа и слева от текущей. По умолчанию: 5.</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>getPageLimit()</td>
        <td>-</td>
        <td>Получить количество видимых ссылок справа и слева от текущей.</td>
        <td>string</td>
    </tr>
    <tr>
        <td>excludeFirstLastLinks($flag)</td>
        <td>$flag: boolean</td>
        <td>Исключить ссылки на первую и последнюю страницы. По умолчанию: false.</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>excludeGroupLinks($flag)</td>
        <td>$flag: boolean</td>
        <td>Исключить ссылки на следующую и предыдущую группы страниц. По умолчанию: false.</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>excludeNextPreviousLinks($flag)</td>
        <td>$flag: boolean</td>
        <td>Исключить ссылки на следующую и предыдущую страницы. По умолчанию: false.</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>excludeNumericLinks($flag)</td>
        <td>$flag: boolean</td>
        <td>Исключить ссылки на нумерованные страницы. По умолчанию: false.</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>setFirstLabel($label)</td>
        <td>$label: string</td>
        <td>Надпись для ссылки на первую страницу. По умолчанию: "<<".</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>setLastLabel($label)</td>
        <td>$label: string</td>
        <td>Надпись для ссылки на последнюю страницу. По умолчанию: ">>".</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>setNextGroupLabel($label)</td>
        <td>$label: string</td>
        <td>Надпись для ссылки на следующую группу страниц. По умолчанию: "..".</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>setPreviousGroupLabel($label)</td>
        <td>$label: string</td>
        <td>Надпись для ссылки на предыдущую группу страниц. По умолчанию: "..".</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>setNextLabel($label)</td>
        <td>$label: string</td>
        <td>Надпись для ссылки на следующую страницу. По умолчанию: ">".</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>setPreviousLabel($label)</td>
        <td>$label: string</td>
        <td>Надпись для ссылки на предыдущую страницу. По умолчанию: "<".</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>setCurrentPage($page)</td>
        <td>$page: integer</td>
        <td>Установить номер отображаемой страницы. По умолчанию: 1.</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>getCurrentPage()</td>
        <td>-</td>
        <td>Получить номер отображаемой страницы.</td>
        <td>integer</td>
    </tr>
    <tr>
        <td>setRecordLimit($limit)</td>
        <td>$limit: integer</td>
        <td>Установить количество записей, отображаемых на странице. По умолчанию: 10.</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>getRecordLimit()</td>
        <td>-</td>
        <td>Получить количество записей, отображаемых на странице.</td>
        <td>integer</td>
    </tr>
    <tr>
        <td>getStart()</td>
        <td>-</td>
        <td>Возвращает номер записи, с которой начат показ страницы (нумерация ведётся с нуля).</td>
        <td>int</td>
    </tr>
    <tr>
        <td>setTotalRecords($total)</td>
        <td>$total: integer</td>
        <td>Установить общее количество всех записей.</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>getTotalPages()</td>
        <td>-</td>
        <td>Получить общее количество всех записей.</td>
        <td>integer</td>
    </tr>
    <tr>
        <td>getPages()</td>
        <td>-</td>
        <td>Получить ссылки постраничной навигации.</td>
        <td>Page[]</td>
    </tr>
    <tr>
        <td>initialize()</td>
        <td>-</td>
        <td>Запустить генерацию постраничной навигации. Необходимо запускать после всех настроек объекта Pagination.</td>
        <td>Pagination</td>
    </tr>
    <tr>
        <td>getStartShow()</td>
        <td>-</td>
        <td>Получить номер записи, с которой начат показ страницы (нумерация ведётся с одного).</td>
        <td>integer</td>
    </tr>
    <tr>
        <td>getEndShow()</td>
        <td>-</td>
        <td>Получить номер последней выведенной записи.</td>
        <td>integer</td>
    </tr>
	</tbody>
</table>

## Методы объекта Page  ##

<table>
	<thead>
		<tr>
			<th>Метод</th>
			<th>Тип возвращаемого значения</th>
			<th>Описание</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>getLabel()</td>
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
    