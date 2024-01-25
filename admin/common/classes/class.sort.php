<?php
class CreateOrder {
	var $orderOptions;
	var $orderBlock;
	var $sortBy;
	var $orderBy;
	var $append;
	var $prepend;
	var $arrow;
	
	function __construct() {
		$this->arrow = $arrow;
		$this->sortBy = $sortBy;
		$this->orderBy = $orderBy;
		$this->orderOptions = '' . $this->sortBy . ' ' . $this->orderBy;
	}
	

	function extra($str) {

		$this->extra .= $str;

	}

	function append($str) {
		$this->append = $str;
	}

	function prepend($str) {
		$this->prepend = $str;
	}

	function addColumn($orderTitle, $orderField, $URL = '', $styleClass = '') {
		if ($this->orderBy == 'ASC') {
			$orderBy = 'DESC';

			if (strchr($_SERVER['PHP_SELF'], 'admin')) {
				$this->arrow = 'images/up.png';
			} else {
				$this->arrow = 'images/up.png';
			}
		} else
			if ($this->orderBy == 'DESC') {
				$orderBy = 'ASC';

				if (strchr($_SERVER['PHP_SELF'], 'admin')) {
					$this->arrow = 'images/down.png';
				} else {
					$this->arrow = 'images/down.png';
				}
			}
		if ($this->sortBy == $orderField) {
			$imgStr = '&nbsp;<img src="' . SITE_ROOT_URL . 'common/' . $this->arrow . '" alt="Sorted in : ' . $this->orderBy . 'ENDING order" title="Sorted in : ' . $this->orderBy . 'ENDING order" />';
		} else
			if ($this->sortBy == ' ORDER BY ' . $orderField) {
				$imgStr = '&nbsp;<img src="' . SITE_ROOT_URL . 'common/' . $this->arrow . '" alt="Sorted in : ' . $this->orderBy . 'ENDING order" title="Sorted in : ' . $this->orderBy . 'ENDING order" />';
			} else {
				$imgStr = '';
			}

		if ($URL == 'no') {
			$this->orderBlock .= '<th class="' . $styleClass . '">' . $this->prepend . $orderTitle . $this->append . '</th>';
		} else {

			if ($orderField == 'PageStatus' || $orderField == 'BlogStatus' || $orderField == 'AdvantageStatus' || $orderField == 'CategoryStatus' || $orderField == 'CustomerStatus' || $orderField == 'ProductStatus') {

				$this->orderBlock .= '<th class="' . $styleClass . '" style="text-align:center"><strong>' . $this->prepend . '<a title="Sort this column in ' . $orderBy . 'ENDING order" style="color:#fff" href="' . $URL . '?sortBy=' . $orderField . '&amp;orderBy=' . $orderBy . $this->extra . '">' . $orderTitle . '</a></strong>' . $imgStr . $this->append . '</th>';
			} else {

				$this->orderBlock .= '<th class="' . $styleClass . '" style="text-align:center"><strong>' . $this->prepend . '<a title="Sort this column in ' . $orderBy . 'ENDING order" style="color:#fff" href="' . $URL . '?sortBy=' . $orderField . '&amp;orderBy=' . $orderBy . $this->extra . '">' . $orderTitle . '</a></strong>' . $imgStr . $this->append . '</th>';
			}
		}
	}

	function orderBlock() {
		return $this->orderBlock;
	}

	function orderOptions() {
		return $this->orderOptions;
	}
}
?>