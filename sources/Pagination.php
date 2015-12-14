<?php

namespace BarinBritva\Pagination;

class Pagination {
	private $url = '';
	private $pageLimit = 5;
	private $excludeFirstLastLinks = false;
	private $excludeGroupLinks = false;
	private $excludeNextPreviousLinks = false;
	private $excludeNumericLinks = false;
	private $firstLabel = '<<';
	private $lastLabel = '>>';
	private $nextGroupLabel = '..';
	private $previousGroupLabel = '..';
	private $nextLabel = '>';
	private $previousLabel = '<';
	private $currentPage = 1;
	private $recordLimit = 10;
	private $totalRecords = 0;

	private $start = 0;
	private $totalPages = 0;
	/** @var Page[] */
	private $pages = [];


	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param string $url
	 *
	 * @return $this
	 */
	public function setUrl($url)
	{
		$this->url = (string)$url;
		return $this;
	}

	public function getPageLimit()
	{
		return $this->pageLimit;
	}

	public function setPageLimit($limit)
	{
		$this->pageLimit = (int)$limit;
		return $this;
	}

	public function excludeFirstLastLinks($flag)
	{
		$this->excludeFirstLastLinks = (bool)$flag;
		return $this;
	}

	public function excludeGroupLinks($flag)
	{
		$this->excludeGroupLinks = (bool)$flag;
		return $this;
	}

	public function excludeNextPreviousLinks($flag)
	{
		$this->excludeNextPreviousLinks = (bool)$flag;
		return $this;
	}

	public function excludeNumericLinks($flag)
	{
		$this->excludeNumericLinks = (bool)$flag;
		return $this;
	}

	public function setFirstLabel($label)
	{
		$this->firstLabel = (string)$label;
		return $this;
	}

	public function setLastLabel($label)
	{
		$this->lastLabel = (string)$label;
		return $this;
	}

	public function setNextGroupLabel($label)
	{
		$this->nextGroupLabel = (string)$label;
		return $this;
	}

	public function setPreviousGroupLabel($label)
	{
		$this->previousGroupLabel = (string)$label;
		return $this;
	}

	public function setNextLabel($label) {
		$this->nextLabel = (string)$label;
		return $this;
	}

	public function setPreviousLabel($label)
	{
		$this->previousLabel = (string)$label;
		return $this;
	}

	public function getCurrentPage()
	{
		return $this->currentPage;
	}

	public function setCurrentPage($page)
	{
		$page = (int)$page;

		if ($page > 0) {
			$this->currentPage = $page;
		}

		return $this;
	}

	public function getRecordLimit()
	{
		return $this->recordLimit;
	}

	public function setRecordLimit($limit)
	{
		$limit = (int)$limit;

		if ($limit > 0) {
			$this->recordLimit = $limit;
		}

		return $this;
	}

	public function getStart()
	{
		return $this->start;
	}

	private function setStart($start)
	{
		$start = (int)$start;

		if ($start > 0) {
			$this->start = (int)$start;
		}

		return $this;
	}

	public function getTotalRecords()
	{
		return $this->totalRecords;
	}

	public function setTotalRecords($total)
	{
		$this->totalRecords = (int)$total;
		return $this;
	}

	public function getTotalPages() {
		return $this->totalPages;
	}

	private function setTotalPages($total)
	{
		$this->totalPages = (int)$total;
		return $this;
	}

	public function getPages()
	{
		return $this->pages;
	}


	public function initialize()
	{
		$page = $this->getCurrentPage();
		$limit = $this->getRecordLimit();
		$totalRecords = $this->getTotalRecords();

		$totalPages = $totalRecords === 0 ? 0 : (int)(($totalRecords - 1) / $limit) + 1;

		if ($page > $totalPages) {
			$page = $totalPages;
			$this->setCurrentPage($page);
		}

		$this
				->setStart($page * $limit - $limit)
				->setTotalPages($totalPages)
				->buildPages();

		return $this;
	}

	public function getStartShow()
	{
		return $this->getStart() + 1;
	}

	public function getEndShow()
	{
		$totalRecords = $this->getTotalRecords();

		$lastRecordOnPage = $this->getCurrentPage() * $this->getRecordLimit();
		if ($lastRecordOnPage > $totalRecords) {
			$lastRecordOnPage = $totalRecords;
		}

		return $lastRecordOnPage;
	}

	private function buildPages()
	{
		$totalPages = $this->getTotalPages();

		if ($totalPages === 0) {
			return $this;
		}

		$page = $this->getCurrentPage();
		$pageLimit = $this->getPageLimit();

		$needFirstAndLastLinks = !$this->excludeFirstLastLinks;
		$needGroupLinks = !$this->excludeGroupLinks;
		$needNextAndPreviousLinks = !$this->excludeNextPreviousLinks;
		$needNumericLinks = !$this->excludeNumericLinks;

		if ($page !== 1) {
			if ($needFirstAndLastLinks) {
				$this->appendPage($this->firstLabel, 1, Page::IS_FIRST);
			}

			if ($needGroupLinks) {
				$previousGroup = $page - $pageLimit * 2 - 1;
				if ($previousGroup > 0) {
					$this->appendPage($this->previousGroupLabel, $previousGroup, Page::IS_PREVIOUS_GROUP);
				}
			}

			if ($needNextAndPreviousLinks) {
				$this->appendPage($this->previousLabel, $page - 1, Page::IS_PREVIOUS);
			}
		}

		if ($needNumericLinks) {
			for ($i = $pageLimit; $i >= 1; $i--) {
				$numericPage = $page - $i;

				if ($numericPage > 0) {
					$this->appendPage($numericPage, $numericPage, Page::IS_NUMERIC);
				}
			}


			$this->appendPage($page, $page, [Page::IS_NUMERIC, Page::IS_CURRENT]);

			for ($i = 1; $i <= $pageLimit; $i++) {
				$numericPage = $page + $i;

				if ($numericPage <= $totalPages) {
					$this->appendPage($numericPage, $numericPage, Page::IS_NUMERIC);
				}
			}
		}

		if ($page != $totalPages) {
			if ($needNextAndPreviousLinks) {
				$this->appendPage($this->nextLabel, $page + 1, Page::IS_NEXT);
			}

			if ($needGroupLinks){
				$nextGroup = $page + $pageLimit * 2 + 1;
				if ($nextGroup <= $totalPages) {
					$this->appendPage($this->nextGroupLabel, $nextGroup, Page::IS_NEXT_GROUP);
				}
			}

			if ($needFirstAndLastLinks) {
				$this->appendPage($this->lastLabel, $totalPages, Page::IS_LAST);
			}
		}

		return $this;
	}

	private function appendPage($caption, $number, $flags)
	{
		$this->pages[] = new Page($caption, $number, $this->getUrl().$number, $flags);
		return $this;
	}
}
