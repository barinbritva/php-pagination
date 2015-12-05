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

	private $start = 0;
	private $totalRecords = 0;
	private $totalPages = 0;
	private $pages = array();

	/** @var PageCounter */
	private $pageCounter;


	public function getUrl() {
		return $this->url;
	}

	public function setUrl($url) {
		$this->url = (string)$url;
		return $this;
	}

	public function getPageLimit() {
		return $this->pageLimit;
	}

	public function setPageLimit($limit) {
		$this->pageLimit = (int)$limit;
		return $this;
	}

	public function excludeFirstLastLinks($flag) {
		$this->excludeFirstLastLinks = (bool)$flag;
		return $this;
	}

	public function excludeGroupLinks($flag) {
		$this->excludeGroupLinks = (bool)$flag;
		return $this;
	}

	public function excludeNextPreviousLinks($flag) {
		$this->excludeNextPreviousLinks = (bool)$flag;
		return $this;
	}

	public function excludeNumericLinks($flag) {
		$this->excludeNumericLinks = (bool)$flag;
		return $this;
	}

	public function setFirstLabel($label) {
		$this->firstLabel = $label;
		return $this;
	}

	public function setLastLabel($label) {
		$this->lastLabel = $label;
		return $this;
	}

	public function setNextGroupLabel($label) {
		$this->nextGroupLabel = $label;
		return $this;
	}

	public function setPreviousGroupLabel($label) {
		$this->previousGroupLabel = $label;
		return $this;
	}

	public function setNextLabel($label) {
		$this->nextLabel = $label;
		return $this;
	}

	public function setPreviousLabel($label) {
		$this->previousLabel = $label;
		return $this;
	}

	public function getCurrentPage() {
		return $this->currentPage;
	}

	private function setCurrentPage($page) {
		$page = (int)$page;

		if ($page > 0) {
			$this->currentPage = $page;
		}

		return $this;
	}

	public function getRecordLimit() {
		return $this->recordLimit;
	}

	public function setRecordLimit($limit) {
		$limit = (int)$limit;

		if ($limit > 0) {
			$this->recordLimit = $limit;
		}

		return $this;
	}

	public function getStart() {
		return $this->start;
	}

	private function setStart($start) {
		$start = (int)$start;

		if ($start > 0) {
			$this->start = (int)$start;
		}

		return $this;
	}

	public function getTotalRecords() {
		return $this->totalRecords;
	}

	private function setTotalRecords($total) {
		$this->totalRecords = (int)$total;
		return $this;
	}

	public function getTotalPages() {
		return $this->totalPages;
	}

	private function setTotalPages($total) {
		$this->totalPages = (int)$total;
		return $this;
	}

	public function getPages() {
		return $this->pages;
	}

	public function __construct(PageCounter $pageCounter) {
		$this->pageCounter = $pageCounter;
	}

	public function initialize() {
		$page = $this->getCurrentPage();
		$limit = $this->getRecordLimit();

		$totalRecords = (int)$this->pageCounter->countTotalRecords();
		$this->setTotalRecords($totalRecords);

		$totalPages = (int)(($totalRecords - 1) / $limit) + 1;

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

	public function getStartShow() {
		return $this->getStart() + 1;
	}

	public function getEndShow() {
		return $this->getStart() + $this->getRecordLimit();
	}

	private function buildPages() {
		$totalPages = $this->getTotalPages();

		if ($totalPages === 0) {
			return $this;
		}

		$page = $this->getCurrentPage();
		$pagesAmount = $this->getPageLimit();

		$needFirstAndLastLinks = !$this->excludeFirstLastLinks;
		$needGroupLinks = !$this->excludeGroupLinks;
		$needNextAndPreviousLinks = !$this->excludeNextPreviousLinks;
		$needNumericLinks = !$this->excludeNumericLinks;

		if ($page !== 1) {
			if ($needFirstAndLastLinks) {
				$this->appendPage($this->firstLabel, 1, 'first');
			}

			if ($needGroupLinks) {
				$previousGroup = $page - $pagesAmount - 1;
				if ($previousGroup > 0) {
					$this->appendPage($this->previousGroupLabel, $previousGroup, 'previous_group');
				}
			}

			if ($needNextAndPreviousLinks) {
				$this->appendPage($this->previousLabel, $page - 1, 'previous');
			}
		}

		if ($needNumericLinks) {
			for ($i = $pagesAmount; $i >= 1; $i--) {
				$numericPage = $page - $i;

				if ($numericPage > 0) {
					$this->appendPage($numericPage, $numericPage, 'numeric');
				}
			}

			if ($totalPages > 1) {
				$this->appendPage($page, $page, 'current');
			}

			for ($i = 1; $i <= $pagesAmount; $i++) {
				$numericPage = $page + $i;

				if ($numericPage <= $totalPages) {
					$this->appendPage($numericPage, $numericPage, 'numeric');
				}
			}
		}

		if ($page != $totalPages) {
			if ($needNextAndPreviousLinks) {
				$this->appendPage($this->nextLabel, $page + 1, 'next');
			}

			if ($needGroupLinks){
				$nextGroup = $page + $pagesAmount + 1;
				if ($nextGroup <= $totalPages) {
					$this->appendPage($this->nextGroupLabel, $nextGroup, 'next_group');
				}
			}

			if ($needFirstAndLastLinks) {
				$this->appendPage($this->lastLabel, $totalPages, 'last');
			}
		}

		return $this;
	}

	private function appendPage($caption, $href, $pageType) {
		$item = array(
			'caption' => $caption,
			'href' => $this->getUrl().$href,
			'is_'.$pageType => 1,
		);

		if ($pageType === 'current') {
			$item['is_numeric'] = 1;
		}

		$this->pages[] = $item;

		return $this;
	}
}
