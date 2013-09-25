<?php

class Pagination {

	const DEFAULT_DRIVER = 'mysql';

	private $_dbConnect;
	private $_table;
	private $_url;
	private $_currentPage = 1;
	private $_limit = 10;
	private $_where = array();
	private $_withPages = true;
	private $_exceptFirstLast = false;
	private $_exceptGroups = false;
	private $_exceptNextPrevious = false;
	private $_exceptNumeric = false;
	private $_pagesAmount = 5;

	private $_labelFirst = '<<<';
	private $_labelLast = '>>>';
	private $_labelNextGroup = '>>';
	private $_labelPreviousGroup = '<<';
	private $_labelNext = '>';
	private $_labelPrevious = '<';

	private $_pagesAttributes = array();

	private $_start = 0;
	private $_totalRecords = 0;
	private $_totalPages = 0;
	private $_pages = array();


	private function _setDbConnect($dbHandler)
	{
		if (
			!is_object($dbHandler) ||
			strtolower(get_class($dbHandler))!=='pdo'
		)
		{
			throw new Exception('Parameters "db" must be PDO object.');
		}

		$this->_dbConnect = $dbHandler;

		return $this;
	}
	private function _getDbConnect()
	{
		return $this->_dbConnect;
	}

	private function _setTable($table)
	{
		$this->_table = $table;
		return $this;
	}
	private function _getTable()
	{
		return $this->_table;
	}

	private function _setUrl($url)
	{
		$this->_url = $url;
		return $this;
	}
	private function _getUrl()
	{
		return $this->_url;
	}

	private function _setCurrentPage($page)
	{
		$this->_currentPage = $page;
		return $this;
	}
	public function getCurrentPage()
	{
		return $this->_currentPage;
	}

	private function _setLimit($limit)
	{
		$this->_limit = $limit;
		return $this;
	}
	public function getLimit()
	{
		return $this->_limit;
	}

	private function _setWhere($where)
	{
		$this->_where = $where;
		return $this;
	}
	private function _getWhere()
	{
		return $this->_where;
	}

	private function _setWithPages($flag)
	{
		$this->_withPages = $flag;
		return $this;
	}
	private function _getWithPages()
	{
		return $this->_withPages;
	}

	private function _setExceptFirstLast($flag)
	{
		$this->_exceptFirstLast = $flag;
		return $this;
	}
	private function _getExceptFirstLast()
	{
		return $this->_exceptFirstLast;
	}

	private function _setExceptGroups($flag)
	{
		$this->_exceptGroups = $flag;
		return $this;
	}
	private function _getExceptGroups()
	{
		return $this->_exceptGroups;
	}

	private function _setExceptNextPrevious($flag)
	{
		$this->_exceptNextPrevious = $flag;
		return $this;
	}
	private function _getExceptNextPrevious()
	{
		return $this->_exceptNextPrevious;
	}

	private function _setExceptNumeric($flag)
	{
		$this->_exceptNumeric = $flag;
		return $this;
	}
	private function _getExceptNumeric()
	{
		return $this->_exceptNumeric;
	}

	private function _setPagesAmount($amount)
	{
		$this->_pagesAmount = $amount;
		return $this;
	}
	public function getPagesAmount()
	{
		return $this->_pagesAmount;
	}

	private function _setLabelFirst($label)
	{
		$this->_labelFirst = $label;
		return $this;
	}
	private function _getLabelFirst()
	{
		return $this->_labelFirst;
	}

	private function _setLabelLast($label)
	{
		$this->_labelLast = $label;
		return $this;
	}
	private function _getLabelLast()
	{
		return $this->_labelLast;
	}

	private function _setLabelNextGroup($label)
	{
		$this->_labelNextGroup = $label;
		return $this;
	}
	private function _getLabelNextGroup()
	{
		return $this->_labelNextGroup;
	}

	private function _setLabelPreviousGroup($label)
	{
		$this->_labelPreviousGroup = $label;
		return $this;
	}
	private function _getLabelPreviousGroup()
	{
		return $this->_labelPreviousGroup;
	}

	private function _setLabelNext($label)
	{
		$this->_labelNext = $label;
		return $this;
	}
	private function _getLabelNext()
	{
		return $this->_labelNext;
	}

	private function _setLabelPrevious($label)
	{
		$this->_labelPrevious = $label;
		return $this;
	}
	private function _getLabelPrevious()
	{
		return $this->_labelPrevious;
	}

	private function _setPagesAttributes($attributes)
	{
		$this->_pagesAttributes = $attributes;
		return $this;
	}
	private function _getPagesAttributes()
	{
		return $this->_pagesAttributes;
	}

	private function _setStart($start)
	{
		$this->_start = $start;
		return $this;
	}
	public function getStart()
	{
		return $this->_start;
	}

	private function _setTotalRecords($total)
	{
		$this->_totalRecords = $total;
		return $this;
	}
	public function getTotalRecords()
	{
		return $this->_totalRecords;
	}

	private function _setTotalPages($total)
	{
		$this->_totalPages = $total;
		return $this;
	}
	public function getTotalPages()
	{
		return $this->_totalPages;
	}

	private function _appendToPages($pageItem)
	{
		$this->_pages[] = $pageItem;
		return $this;
	}
	public function getPages()
	{
		return $this->_pages;
	}


	public function __construct($parameters)
	{
		$this
			->_setUserParameters($parameters)
			->_initialize();
	}


	private function _setUserParameters($parameters)
	{
		if (!is_array($parameters))
		{
			throw new Exception('Parameters must be array.');
		}

		if (!empty($parameters['db']))
		{
			$this->_setDbConnect($parameters['db']);
		}
		elseif (!empty($parameters['db_config']))
		{
			$this->_openDbConnect($parameters['db_config']);
		}
		else
		{
			throw new Exception('Parameter "db" or "db_config" is required.');
		}

		if (!empty($parameters['table']))
		{
			$this->_setTable((string)$parameters['table']);
		}
		else
		{
			throw new Exception('Parameter "table" is required.');
		}

		if (!empty($parameters['url']))
		{
			$this->_setUrl((string)$parameters['url']);
		}
		else
		{
			throw new Exception('Parameter "url" is required.');
		}

		if (!empty($parameters['page']))
		{
			$page = (int)$parameters['page'];

			if ($page>0)
			{
				$this->_setCurrentPage($page);
			}
		}

		if (!empty($parameters['limit']))
		{
			$limit = (int)$parameters['limit'];

			if ($limit>0)
			{
				$this->_setLimit($limit);
			}
		}

		if (
			!empty($parameters['where']) &&
			is_array($parameters['where'])
		)
		{
			$this->_setWhere($parameters['where']);
		}

		if (isset($parameters['with_pages']))
		{
			$this->_setWithPages((boolean)$parameters['with_pages']);
		}

		if (isset($parameters['except_first_last']))
		{
			$this->_setExceptFirstLast((boolean)$parameters['except_first_last']);
		}

		if (isset($parameters['except_groups']))
		{
			$this->_setExceptGroups((boolean)$parameters['except_groups']);
		}

		if (isset($parameters['except_next_previous']))
		{
			$this->_setExceptNextPrevious((boolean)$parameters['except_next_previous']);
		}

		if (isset($parameters['except_numeric']))
		{
			$this->_setExceptNumeric((boolean)$parameters['except_numeric']);
		}

		if (!empty($parameters['pages_amount']))
		{
			$this->_setPagesAmount((int)$parameters['pages_amount']);
		}

		if (!empty($parameters['label_first']))
		{
			$this->_setLabelFirst((string)$parameters['label_first']);
		}

		if (!empty($parameters['label_last']))
		{
			$this->_setLabelLast((string)$parameters['label_last']);
		}

		if (!empty($parameters['label_next_group']))
		{
			$this->_setLabelNextGroup((string)$parameters['label_next_group']);
		}

		if (!empty($parameters['label_previous_group']))
		{
			$this->_setLabelPreviousGroup((string)$parameters['label_previous_group']);
		}

		if (!empty($parameters['label_next']))
		{
			$this->_setLabelNext((string)$parameters['label_next']);
		}

		if (!empty($parameters['label_previous']))
		{
			$this->_setLabelPrevious((string)$parameters['label_previous']);
		}

		if (
			!empty($parameters['pages_attributes']) &&
			is_array($parameters['pages_attributes'])
		)
		{
			$this->_setPagesAttributes($parameters['pages_attributes']);
		}

		return $this;
	}

	private function _openDbConnect($parameters)
	{
		$requiredParameters = array('host', 'database', 'user', 'password');
		foreach($requiredParameters as $parameter)
		{
			if (!array_key_exists($parameter, $parameters))
			{
				throw new Exception('Parameter "'.$parameter.'" in db_config is required');
			}
		}

		$driver =  empty($parameters['driver']) ? self::DEFAULT_DRIVER : $parameters['driver'];
		$port = empty($parameters['port']) ? '' : ';port='.$parameters['port'];

		$pdo = new PDO(
			$driver.':host='.$parameters['host'].$port.';dbname='.$parameters['database'],
			$parameters['user'],
			$parameters['password']
		);

		$this->_setDbConnect($pdo);
	}

	private function _initialize()
	{
		$page = $this->getCurrentPage();
		$limit = $this->getLimit();

		$this->_countTotalRecords();
		$totalRecords = $this->getTotalRecords();

		$totalPages = (int)(($totalRecords - 1) / $limit) + 1;

		if ($page>$totalPages)
		{
			$page = $totalPages;
			$this->_setCurrentPage($page);
		}

		$this
			->_setStart($page * $limit - $limit)
			->_setTotalPages($totalPages)
			->_buildPages();

		return $this;
	}

	private function _countTotalRecords()
	{
		$dbConnect = $this->_getDbConnect();

		$query = "SELECT COUNT(*) AS total FROM ".$this->_getTable().$this->_prepareWhere();
		$result = $dbConnect->query($query);

		$errorInfo = $dbConnect->errorInfo();
		$errorInfo = $errorInfo[2];
		if ($errorInfo!==null)
		{
			throw new Exception('Unable to count records: '.$errorInfo);
		}

		$result = $result->fetchObject();
		$this->_setTotalRecords($result->total);

		return $this;
	}

	private function _prepareWhere()
	{
		$where = $this->_getWhere();

		$whereString = empty($where) ? '' : ' WHERE ';
		$delimiter = '';

		foreach ($where as $key=>$value)
		{
			$operator = $this->_hasOperator($key) ? ' ' : ' = ';
			$value = $this->_prepareValue($value);

			$whereString .= $delimiter.$key.$operator.$value;
			$delimiter = ' AND ';
		}

		return $whereString;
	}

	private function _hasOperator($string)
	{
		$string = trim($string);
		if (preg_match("/(\s|<|>|!|=|is null|is not null|in|not in)/i", $string))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	private function _prepareValue($value)
	{
		$dbConnect = $this->_getDbConnect();

		$valueType = strtolower(gettype($value));

		switch($valueType)
		{
			case 'array':
				foreach ($value as $item)
				{
					$valueEscaped[] = $dbConnect->quote($item);
				}
				$value = "(".implode(', ', $valueEscaped).")";
			break;

			case 'null':
				$value = '';
			break;

			default:
				$value = $dbConnect->quote($value);
			break;
		}

		return $value;
	}

	private function _buildPages($forcibly=false)
	{
		if (
			$this->_getWithPages()===true ||
			$forcibly===true
		)
		{
			$page = $this->getCurrentPage();
			$pagesAmount = $this->getPagesAmount();
			$totalPages = $this->getTotalPages();

			$firstLast = !$this->_getExceptFirstLast();
			$groups = !$this->_getExceptGroups();
			$nextPrevious = !$this->_getExceptNextPrevious();
			$numeric = !$this->_getExceptNumeric();

			if ($page!==1)
			{
				if ($firstLast)
				{
					$this->_appendPage($this->_getLabelFirst(), 1, 'first');
				}

				if ($groups)
				{
					$previousGroup = $page-$pagesAmount-1;
					if ($previousGroup>0)
					{
						$this->_appendPage($this->_getLabelPreviousGroup(), $previousGroup, 'previous_group');
					}
				}

				if ($nextPrevious)
				{
					$this->_appendPage($this->_getLabelPrevious(), $page-1, 'previous');
				}
			}

			if ($numeric)
			{
				for ($i=$pagesAmount; $i>=1; $i--)
				{
					$numericPage = $page-$i;
					if ($numericPage>0)
					{
						$this->_appendPage($numericPage, $numericPage, 'numeric');
					}
				}

				if ($totalPages>1)
				{
					$this->_appendPage($page, $page, 'current');
				}

				for ($i=1; $i<=$pagesAmount; $i++)
				{
					$numericPage = $page+$i;
					if ($numericPage<=$totalPages)
					{
						$this->_appendPage($numericPage, $numericPage, 'numeric');
					}
				}
			}

			if ($page!=$totalPages)
			{
				if ($nextPrevious)
				{
					$this->_appendPage($this->_getLabelNext(), $page+1, 'next');
				}

				if ($groups)
				{
					$nextGroup = $page+$pagesAmount+1;
					if ($nextGroup<=$totalPages)
					{
						$this->_appendPage($this->_getLabelNextGroup(), $nextGroup, 'next_group');
					}
				}

				if ($firstLast)
				{
					$this->_appendPage($this->_getLabelLast(), $totalPages, 'last');
				}
			}
		}

		return $this;
	}

	private function _appendPage($caption, $href, $pageType)
	{
		$item = array(
			'caption' => $caption,
			'href' => $this->_getUrl().$href,
			'is_'.$pageType => 1,
		);

		$attributes = $this->_getPageAttributes($pageType);
		if ($pageType==='current')
		{
			$item['is_numeric'] = 1;
			$attributes = array_merge($this->_getPageAttributes('numeric'), $attributes);
		}
		$item['attributes'] = $attributes;

		$this->_appendToPages($item);

		return $this;
	}

	private function _getPageAttributes($pageType)
	{
		$attributes = $this->_getPagesAttributes();

		if (
			!empty($attributes[$pageType]) &&
			is_array($attributes[$pageType])
		)
		{
			return $attributes[$pageType];
		}
		else
		{
			return array();
		}
	}

	public function get()
	{
		return array(
			'current_page' => $this->getCurrentPage(),
			'start' => $this->getStart(),
			'limit' => $this->getLimit(),
			'start_show' => $this->getStartShow(),
			'end_show' => $this->getEndShow(),
			'total_records' => $this->getTotalRecords(),
			'total_pages' => $this->getTotalPages(),
			'pages' => $this->getPages()
		);
	}

	public function getStartShow()
	{
		return $this->getStart()+1;
	}

	public function getEndShow()
	{
		return $this->getStart()+$this->getLimit();
	}

	public function buildPages()
	{
		$this->_buildPages(true);
		return $this;
	}

}

?>