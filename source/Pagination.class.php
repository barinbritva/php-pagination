<?php

class Pagination {

	const DEFAULT_DRIVER = 'mysql';

	private $_db_connect;
	private $_table;
	private $_url;
	private $_current_page = 1;
	private $_limit = 10;
	private $_where = array();
	private $_with_pages = true;
	private $_except_first_last = false;
	private $_except_groups = false;
	private $_except_next_previous = false;
	private $_except_numeric = false;
	private $_pages_amount = 5;

	private $_label_first = '<<<';
	private $_label_last = '>>>';
	private $_label_next_group = '>>';
	private $_label_previous_group = '<<';
	private $_label_next = '>';
	private $_label_previous = '<';

	private $_pages_attributes = array();

	private $_start = 0;
	private $_total_records = 0;
	private $_total_pages = 0;
	private $_pages = array();


	private function _set_db_connect($db_handler)
	{
		if (
			!is_object($db_handler) ||
			strtolower(get_class($db_handler))!=='pdo'
		)
		{
			throw new Exception('Parameters "db" must be PDO object.');
		}

		$this->_db_connect = $db_handler;

		return $this;
	}
	private function _get_db_connect()
	{
		return $this->_db_connect;
	}

	private function _set_table($table)
	{
		$this->_table = $table;
		return $this;
	}
	private function _get_table()
	{
		return $this->_table;
	}

	private function _set_url($url)
	{
		$this->_url = $url;
		return $this;
	}
	private function _get_url()
	{
		return $this->_url;
	}

	private function _set_current_page($page)
	{
		$this->_current_page = $page;
		return $this;
	}
	public function get_current_page()
	{
		return $this->_current_page;
	}

	private function _set_limit($limit)
	{
		$this->_limit = $limit;
		return $this;
	}
	public function get_limit()
	{
		return $this->_limit;
	}

	private function _set_where($where)
	{
		$this->_where = $where;
		return $this;
	}
	private function _get_where()
	{
		return $this->_where;
	}

	private function _set_with_pages($flag)
	{
		$this->_with_pages = $flag;
		return $this;
	}
	private function _get_with_pages()
	{
		return $this->_with_pages;
	}

	private function _set_except_first_last($flag)
	{
		$this->_except_first_last = $flag;
		return $this;
	}
	private function _get_except_first_last()
	{
		return $this->_except_first_last;
	}

	private function _set_except_groups($flag)
	{
		$this->_except_groups = $flag;
		return $this;
	}
	private function _get_except_groups()
	{
		return $this->_except_groups;
	}

	private function _set_except_next_previous($flag)
	{
		$this->_except_next_previous = $flag;
		return $this;
	}
	private function _get_except_next_previous()
	{
		return $this->_except_next_previous;
	}

	private function _set_except_numeric($flag)
	{
		$this->_except_numeric = $flag;
		return $this;
	}
	private function _get_except_numeric()
	{
		return $this->_except_numeric;
	}

	private function _set_pages_amount($amount)
	{
		$this->_pages_amount = $amount;
		return $this;
	}
	public function get_pages_amount()
	{
		return $this->_pages_amount;
	}

	private function _set_label_first($label)
	{
		$this->_label_first = $label;
		return $this;
	}
	private function _get_label_first()
	{
		return $this->_label_first;
	}

	private function _set_label_last($label)
	{
		$this->_label_last = $label;
		return $this;
	}
	private function _get_label_last()
	{
		return $this->_label_last;
	}

	private function _set_label_next_group($label)
	{
		$this->_label_next_group = $label;
		return $this;
	}
	private function _get_label_next_group()
	{
		return $this->_label_next_group;
	}

	private function _set_label_previous_group($label)
	{
		$this->_label_previous_group = $label;
		return $this;
	}
	private function _get_label_previous_group()
	{
		return $this->_label_previous_group;
	}

	private function _set_label_next($label)
	{
		$this->_label_next = $label;
		return $this;
	}
	private function _get_label_next()
	{
		return $this->_label_next;
	}

	private function _set_label_previous($label)
	{
		$this->_label_previous = $label;
		return $this;
	}
	private function _get_label_previous()
	{
		return $this->_label_previous;
	}

	private function _set_pages_attributes($attributes)
	{
		$this->_pages_attributes = $attributes;
		return $this;
	}
	private function _get_pages_attributes()
	{
		return $this->_pages_attributes;
	}

	private function _set_start($start)
	{
		$this->_start = $start;
		return $this;
	}
	public function get_start()
	{
		return $this->_start;
	}

	private function _set_total_records($total)
	{
		$this->_total_records = $total;
		return $this;
	}
	public function get_total_records()
	{
		return $this->_total_records;
	}

	private function _set_total_pages($total)
	{
		$this->_total_pages = $total;
		return $this;
	}
	public function get_total_pages()
	{
		return $this->_total_pages;
	}

	private function _append_to_pages($page_item)
	{
		$this->_pages[] = $page_item;
		return $this;
	}
	public function get_pages()
	{
		return $this->_pages;
	}


	public function __construct($parameters)
	{
		$this
			->_set_user_parameters($parameters)
			->_initialize();
	}


	private function _set_user_parameters($parameters)
	{
		if (!is_array($parameters))
		{
			throw new Exception('Parameters must be array.');
		}

		if (!empty($parameters['db']))
		{
			$this->_set_db_connect($parameters['db']);
		}
		elseif (!empty($parameters['db_config']))
		{
			$this->_open_db_connect($parameters['db_config']);
		}
		else
		{
			throw new Exception('Parameter "db" is required.');
		}

		if (!empty($parameters['table']))
		{
			$this->_set_table((string)$parameters['table']);
		}
		else
		{
			throw new Exception('Parameter "table" is required.');
		}

		if (!empty($parameters['url']))
		{
			$this->_set_url((string)$parameters['url']);
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
				$this->_set_current_page($page);
			}
		}

		if (!empty($parameters['limit']))
		{
			$limit = (int)$parameters['limit'];

			if ($limit>0)
			{
				$this->_set_limit($limit);
			}
		}

		if (
			!empty($parameters['where']) &&
			is_array($parameters['where'])
		)
		{
			$this->_set_where($parameters['where']);
		}

		if (isset($parameters['with_pages']))
		{
			$this->_set_with_pages((boolean)$parameters['with_pages']);
		}

		if (isset($parameters['except_first_last']))
		{
			$this->_set_except_first_last((boolean)$parameters['except_first_last']);
		}

		if (isset($parameters['except_groups']))
		{
			$this->_set_except_groups((boolean)$parameters['except_groups']);
		}

		if (isset($parameters['except_next_previous']))
		{
			$this->_set_except_next_previous((boolean)$parameters['except_next_previous']);
		}

		if (isset($parameters['except_numeric']))
		{
			$this->_set_except_numeric((boolean)$parameters['except_numeric']);
		}

		if (!empty($parameters['pages_amount']))
		{
			$this->_set_pages_amount((int)$parameters['pages_amount']);
		}

		if (!empty($parameters['label_first']))
		{
			$this->_set_label_first((string)$parameters['label_first']);
		}

		if (!empty($parameters['label_last']))
		{
			$this->_set_label_last((string)$parameters['label_last']);
		}

		if (!empty($parameters['label_next_group']))
		{
			$this->_set_label_next_group((string)$parameters['label_next_group']);
		}

		if (!empty($parameters['label_previous_group']))
		{
			$this->_set_label_previous_group((string)$parameters['label_previous_group']);
		}

		if (!empty($parameters['label_next']))
		{
			$this->_set_label_next((string)$parameters['label_next']);
		}

		if (!empty($parameters['label_previous']))
		{
			$this->_set_label_previous((string)$parameters['label_previous']);
		}

		if (
			!empty($parameters['pages_attributes']) &&
			is_array($parameters['pages_attributes'])
		)
		{
			$this->_set_pages_attributes($parameters['pages_attributes']);
		}

		return $this;
	}

	private function _open_db_connect($parameters)
	{
		$required_parameters = array('host', 'database', 'user', 'password');
		foreach($required_parameters as $parameter)
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

		$this->_set_db_connect($pdo);
	}

	private function _initialize()
	{
		$page = $this->get_current_page();
		$limit = $this->get_limit();

		$this->_count_total_records();
		$total_records = $this->get_total_records();

		$total_pages = (int)(($total_records - 1) / $limit) + 1;

		if ($page>$total_pages)
		{
			$page = $total_pages;
			$this->_set_current_page($page);
		}

		$this
			->_set_start($page * $limit - $limit)
			->_set_total_pages($total_pages)
			->_build_pages();

		return $this;
	}

	private function _count_total_records()
	{
		$db_connect = $this->_get_db_connect();

		$query = "SELECT COUNT(id) AS total FROM ".$this->_get_table().$this->_prepare_where();
		$result = $db_connect->query($query);

		$error_info = $db_connect->errorInfo();
		$error_info = $error_info[2];
		if ($error_info!==null)
		{
			throw new Exception('Unable to count records: '.$error_info);
		}

		$result = $result->fetchObject();
		$this->_set_total_records($result->total);

		return $this;
	}

	private function _prepare_where()
	{
		$db_connect = $this->_get_db_connect();
		$where = $this->_get_where();

		$where_string = empty($where) ? '' : ' WHERE ';
		$delimiter = '';

		foreach ($where as $key=>$value)
		{
			$operator = $this->_has_operator($key) ? '' : '=';
			$value = is_null($value) ? '' : $db_connect->quote($value);

			$where_string .= $delimiter.$key.$operator.$value;
			$delimiter = ' AND ';
		}

		return $where_string;
	}

	private function _has_operator($string)
	{
		$string = trim($string);
		if (preg_match("/(\s|<|>|!|=|is null|is not null)/i", $string))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	private function _build_pages($forcibly=false)
	{
		if (
			$this->_get_with_pages()===true ||
			$forcibly===true
		)
		{
			$page = $this->get_current_page();
			$pages_amount = $this->get_pages_amount();
			$total_pages = $this->get_total_pages();

			$first_last = !$this->_get_except_first_last();
			$groups = !$this->_get_except_groups();
			$next_previous = !$this->_get_except_next_previous();
			$numeric = !$this->_get_except_numeric();

			if ($page!==1)
			{
				if ($first_last)
				{
					$this->_append_page($this->_get_label_first(), 1, 'first');
				}

				if ($groups)
				{
					$previous_group = $page-$pages_amount-1;
					if ($previous_group>0)
					{
						$this->_append_page($this->_get_label_previous_group(), $previous_group, 'previous_group');
					}
				}

				if ($next_previous)
				{
					$this->_append_page($this->_get_label_previous(), $page-1, 'previous');
				}
			}

			if ($numeric)
			{
				for ($i=$pages_amount; $i>=1; $i--)
				{
					$numeric_page = $page-$i;
					if ($numeric_page>0)
					{
						$this->_append_page($numeric_page, $numeric_page, 'numeric');
					}
				}

				if ($total_pages>1)
				{
					$this->_append_page($page, $page, 'current');
				}

				for ($i=1; $i<=$pages_amount; $i++)
				{
					$numeric_page = $page+$i;
					if ($numeric_page<=$total_pages)
					{
						$this->_append_page($numeric_page, $numeric_page, 'numeric');
					}
				}
			}

			if ($page!=$total_pages)
			{
				if ($next_previous)
				{
					$this->_append_page($this->_get_label_next(), $page+1, 'next');
				}

				if ($groups)
				{
					$next_group = $page+$pages_amount+1;
					if ($next_group<=$total_pages)
					{
						$this->_append_page($this->_get_label_next_group(), $next_group, 'next_group');
					}
				}

				if ($first_last)
				{
					$this->_append_page($this->_get_label_last(), $total_pages, 'last');
				}
			}
		}

		return $this;
	}

	private function _append_page($caption, $href, $page_type)
	{
		$item = array(
			'caption' => $caption,
			'href' => $this->_get_url().$href,
			'is_'.$page_type => 1,
		);

		$attributes = $this->_get_page_attributes($page_type);
		if ($page_type==='current')
		{
			$item['is_numeric'] = 1;
			$attributes = array_merge($this->_get_page_attributes('numeric'), $attributes);
		}
		$item['attributes'] = $attributes;

		$this->_append_to_pages($item);

		return $this;
	}

	private function _get_page_attributes($page_type)
	{
		$attributes = $this->_get_pages_attributes();

		if (
			!empty($attributes[$page_type]) &&
			is_array($attributes[$page_type])
		)
		{
			return $attributes[$page_type];
		}
		else
		{
			return array();
		}
	}

	public function get()
	{
		return array(
			'current_page' => $this->get_current_page(),
			'start' => $this->get_start(),
			'limit' => $this->get_limit(),
			'start_show' => $this->get_start_show(),
			'end_show' => $this->get_end_show(),
			'total_records' => $this->get_total_records(),
			'total_pages' => $this->get_total_pages(),
			'pages' => $this->get_pages()
		);
	}

	public function get_start_show()
	{
		return $this->get_start()+1;
	}

	public function get_end_show()
	{
		return $this->get_start()+$this->get_limit();
	}

	public function build_pages()
	{
		$this->_build_pages(true);
		return $this;
	}

}

?>