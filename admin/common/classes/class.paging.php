<?php
class Paging extends Core {

	var $page;
	var $next_page;
	var $prev_page;
	var $num_pages;

	function getPageStartLimit($argPage, $argLimit) {
		if ($argPage == '' || $argPage == 0) {
			$argPage = 1;

		}
		$varPageStart = ($argLimit * $argPage) - $argLimit;

		return $varPageStart;

	}

	function calculateNumberofPages($argNumRows, $argLimit) {

		if ($argNumRows > $argLimit) {

			if ($argNumRows % $argLimit == 0) {

				$this->num_pages = ($argNumRows / $argLimit);

			} else {

				$this->num_pages = ($argNumRows / $argLimit) + 1;

				$this->num_pages = ( int ) $this->num_pages;

			}

		} else
			if ($argNumRows <= argLimit) {

				$this->num_pages = 1;

			}

		return $this->num_pages;

	}

	function displayPaging($page, $num_pages, $limit, $varPageName = '', $varPageID = '', $arrRequest = '', $argDispName = '') {

		$objCore = new Core();
		if ($page == "") {
			$page = 1;
		}

		$this->page = $page;

		$this->next_page = $page +1;

		$this->prev_page = $page -1;

		$this->num_pages = $num_pages;

		$varReques = $_REQUEST;
		//print_r($_REQUEST);
		if (isset ($varReques['PHPSESSID'])) {
			unset ($varReques['PHPSESSID']);
		}
		if (isset ($varReques['__utmz'])) {

			unset ($varReques['__utmz']);
		}
		if (isset ($varReques['__utma'])) {

			unset ($varReques['__utma']);

		}
		if (isset ($varReques['__utmc'])) {

			unset ($varReques['__utmc']);

		}
		if (isset ($varReques['__utmb'])) {

			unset ($varReques['__utmb']);

		}
		if (isset ($varReques['celeb'])) {

			unset ($varReques['celeb']);

		}
		if ($argDispName == '') {

			$varDispName = 'page';

			$varQryStr = $objCore->generateValidateString($varRequest, '', $varDispName);

		} else {
			$varDispName = $argDispName;

		}

		$varQryStr = $this->qryStr($varReques, 'cookie_AgentUserPassword');

		$varQryStr = str_replace('?&' . $varDispName, '?' . $varDispName, $varQryStr);

		$varQryStr = str_replace('&' . $varDispName, '&amp;' . $varDispName, $varQryStr);

		$varQryStr = $objCore->generateValidateString($varRequest, '', $varDispName);


		$varRequest = $_SERVER['QUERY_STRING'];

		$varQryStr = $_SERVER['QUERY_STRING'];

		if (trim($varQryStr) == '') {

			$varQryStr = '?' . $varQryStr;
		} else {

			$varQryStr = '?' . preg_replace('/&page=([0-9])+/', '', $varQryStr) . '&amp;';

		}

		$page_list = '<p class="paging">';
		if ($this->page > 10) //was commented
			{
			if (($this->page - 1) > 0) {
				if ($varPageName != '' && $varPageID != '') {
					$page_list .= '<a href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . ($this->page - 10) . '&amp;PageName=' . $varPageName . '&amp;PageId=' . $varPageID . '" class="back" >&lt;&lt;&nbsp;Back10</a>';
				} else {
					$page_list .= '&nbsp;<a href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . ($this->page - 10) . '" class="back" >&lt;&lt;&nbsp;Back10</a>&nbsp;';
				}
			}
		}

		if (($this->page - 1) > 0) {

			if ($varPageName != '' && $varPageID != '') {

				$page_list .= '&nbsp;<a href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . ($this->page - 1) . '&amp;PageName=' . $varPageName . '&amp;PageId=' . $varPageID . '" class="back" >&lt;&lt;&nbsp;Back</a>&nbsp;';
				//$page_list .= '&nbsp;<a href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . (1) . '&amp;PageName=' . $varPageName . '&amp;PageId=' . $varPageID . '" class="back" >&lt;&lt;&nbsp;first</a>&nbsp;';

			} else {

				$page_list .= '&nbsp;<a href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . ($this->page - 1) . '" class="back" >&lt;&lt;&nbsp;Back </a>&nbsp;';
				$page_list .= '&nbsp;<a href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . (1) . '" class="back" >&lt;&lt;&nbsp;First</a>&nbsp;';

			}

		} else {

			if ($varPageName != '' && $varPageID != '') {

				$page_list .= '&nbsp;<span class="disabled">&lt;&lt;&nbsp;Back</span>';

			} else {

				$page_list .= '&nbsp;<span class="disabled">&lt;&lt;&nbsp;Back</span>&nbsp;';

			}

		}

		$varPageList1 = '' . $page_list . '';

		$page_list = "";

		//code for paging if number of pages are more than 10
		if ($this->num_pages > 5) {
			$i = $this->page;
			$totalpage = $this->page + 4;
			if ($this->page <= 5) {
				$varshowTen = 1;
			} else {
				$varshowTen = $this->page - 5;
			}

			for ($i = $varshowTen; $i <= $totalpage; $i++) {

				//paging by default display l page condition added 
				if ($i > $this->num_pages) {
					break;
				}

				if ($this->num_pages > 1) {
					if ($i == $this->page) {
						$page_list .= '<span class="text"><strong>' . $i . '</strong></span>';
					} else {
						if ($varPageName != '' && $varPageID != '') {
							$page_list .= '&nbsp;<a style="text-decoration:underline" href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . $i . '&amp;PageName=' . $varPageName . '&amp;PageId=' . $varPageID . '">' . $i . ' </a>&nbsp;';
						} else {
							$page_list .= '&nbsp;<a style="text-decoration:underline" href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . $i . '">' . $i . ' </a>&nbsp;';
						}
					}
				}
			}

			if ($totalpage < $this->num_pages) {
				if (($totalpage +1) < $this->num_pages) {
					$page_list .= '<a><strong>...</strong></a>';
				}
				$page_list .= '&nbsp;<a style="text-decoration:underline" href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . $this->num_pages . '">' . $this->num_pages . '</a>&nbsp;';
			}
		} else {
			for ($x = 1; $x <= $this->num_pages; $x++) {
				if ($x == $this->page) {
					//shows paging only if number of pages is greater than one 
					if ($this->num_pages > 1) {
						$page_list .= '&nbsp;<a><span>' . $x . '</span></a>&nbsp;';
					}
				} else {
					if ($varPageName != '' && $varPageID != '') {
						$page_list .= '&nbsp;<a style="text-decoration:underline" href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . $x . '&amp;PageName=' . $varPageName . '&amp;PageId=' . $varPageID . '" >' . $x . '</a>&nbsp;';
					} else {
						$page_list .= '&nbsp;<a style="text-decoration:underline" href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . $x . '" >' . $x . '</a>&nbsp;';
					}
				}
			}
		} //end of if else condition
		$varPageList2 = '' . $page_list . '';
		$page_list = "";
		// Print the Next and Last page links if necessary 
		if (($this->page + 1) <= $this->num_pages) {
			if ($varPageName != '' && $varPageID != '') {
				$page_list .= '&nbsp;<a href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . ($this->page + 1) . '&amp;PageName=' . $varPageName . '&amp;PageId=' . $varPageID . '" class="continue" >Continue&nbsp;&gt;&gt;</a>&nbsp;';
			} else {
				$page_list .= '&nbsp;<a href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . ($this->page + 1) . '" class="continue" >Continue&nbsp;&gt;&gt;</a>&nbsp;';
				$page_list .= '&nbsp;<a href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . $this->num_pages . '" class="continue" >Last&nbsp;&gt;&gt;</a>&nbsp;'; //Added by Ipraxa
			}
		} else {
			if ($varPageName != '' && $varPageID != '') {
				$page_list .= '&nbsp;<span class="disabled">Continue&nbsp;&gt;&gt;</span>&nbsp;';
			} else {
				$page_list .= '&nbsp;<span class="disabled">Continue&nbsp;&gt;&gt;</span>&nbsp;';

			}

		}

		if ($totalpage <= $this->num_pages) //was commented

			{

			if (($this->page + 10) <= $this->num_pages) {

				if ($varPageName != '' && $varPageID != '') {

					$page_list .= '<a href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . ($this->page + 10) . '&amp;PageName=' . $varPageName . '&amp;PageId=' . $varPageID . '" class="continue">Continue10&nbsp;&gt;&gt;</a>';

				} else {

					$page_list .= '<a href="' . $PHP_SELF . $varQryStr . $varDispName . '=' . ($this->page + 10) . '" class="continue" >Continue10&nbsp;&gt;&gt;</a>';

				}

			}

		}

		$varPageList3 = '' . $page_list . '';

		$varPageListing = $varPageList1 . $varPageList2 . $varPageList3;

		$page_list .= "";

		echo $varPageListing . '</p>';

	} //end of function

	function displaySingleLinkPaging($argVarBackLinkString, $argVarNextLinkString, $argVarCurrentPage, $argVarTotalPages) {

		$varQryStr = $_SERVER['QUERY_STRING'];

		if (trim($varQryStr) == '') {

			$varQryStr = '?' . $varQryStr;

		} else {

			$varQryStr = '?' . preg_replace('/&page=([0-9]*)/', '', $varQryStr) . '&amp;';

		}

		if ($argVarTotalPages > 1) {

			//get next page link

			if ($argVarCurrentPage == $argVarTotalPages) {

				$varNextPageLink = '<span style="background:transparent none repeat scroll 0 0; color:#A0A0A0;">' . $argVarNextLinkString . '</span>';

			} else
				if ($argVarCurrentPage != '') {

					$varNextPageLink = '<a href="' . $PHP_SELF . $varQryStr . 'page=' . ($argVarCurrentPage +1) . '">' . $argVarNextLinkString . '</a>';

				} else {

					$varNextPageLink = '<a href="' . $PHP_SELF . $varQryStr . 'page=2">' . $argVarNextLinkString . '</a>';

				}

			//get previous page link

			if ($argVarCurrentPage == '' || $argVarCurrentPage == '1') {

				$varPreviousPageLink = '<span style="background:transparent none repeat scroll 0 0; color:#A0A0A0;">' . $argVarBackLinkString . '</span>';

			} else //if($_GET['page'] != '' )

				{

				$varPreviousPageLink = '<a href="' . $PHP_SELF . $varQryStr . 'page=' . ($argVarCurrentPage -1) . '">' . $argVarBackLinkString . '</a>';

			}

			$arrLinks['Prev'] = $varPreviousPageLink;

			$arrLinks['Next'] = $varNextPageLink;

			return $arrLinks;

		}

	}

	function displayFrontPaging($page, $num_pages, $limit, $varPageName = '', $varPageID = '', $arrRequest = '') {

		if ($page == "") {

			$page = 1;

		}

		$this->page = $page;

		$this->next_page = $page +1;

		$this->prev_page = $page -1;

		$this->num_pages = $num_pages;

		$varReques = $_REQUEST;

		$varQryStr = $this->qryStr($varReques, 'cookie_AgentUserPassword');

		$varQryStr = str_replace('?&page', '?page', $varQryStr);

		$varQryStr = str_replace('&page', '&amp;page', $varQryStr);

		if (($this->page - 1) > 0) {

			if ($varPageName != '' && $varPageID != '') {

				$page_list .= '<span><a href="' . $PHP_SELF . $varQryStr . '&amp;page=' . ($this->page - 1) . '&amp;PageName=' . $varPageName . '&amp;PageId=' . $varPageID . '" class="previous"><span>&#171;&nbsp;</span>Previous</a></span>';

			} else {

				$page_list .= '<span><a href="' . $PHP_SELF . $varQryStr . '&amp;page=' . ($this->page - 1) . '" class="previous"><span>&#171;&nbsp;</span>Previous</a></span>';

			}

		}

		$varPageList1 = '' . $page_list . '';

		$page_list = "";

		if ($this->num_pages > 10) {

			$i = $this->page;

			$totalpage = $this->page + 9;

			for ($i = $this->page; $i <= $totalpage; $i++) {

				if ($i > $this->num_pages) {
					break;
				}

				if ($this->num_pages > 1) {

					if ($i == $this->page) {

						$page_list .= '<span class="current"><strong>' . $i . '</strong></span>';

					} else {

						if ($varPageName != '' && $varPageID != '') {

							$page_list .= '<span><a  href="' . $PHP_SELF . $varQryStr . '&amp;page=' . $i . '&amp;PageName=' . $varPageName . '&amp;PageId=' . $varPageID . '">&nbsp;&nbsp;' . $i . '&nbsp;&nbsp;</a></span>';

						} else {

							$page_list .= '<span><a  href="' . $PHP_SELF . $varQryStr . '&amp;page=' . $i . '">&nbsp;&nbsp;' . $i . '&nbsp;&nbsp;</a></span>';

						}

					}

				}

			}

		} else {

			for ($x = 1; $x <= $this->num_pages; $x++) {

				if ($x == $this->page) {

					if ($this->num_pages > 1) {

						$page_list .= '<span><a class="current"><strong">&nbsp;&nbsp;' . $x . '&nbsp;&nbsp;</strong></a></span>';

					}

				} else {

					if ($varPageName != '' && $varPageID != '') {

						$page_list .= '<span><a href="' . $PHP_SELF . $varQryStr . '&amp;page=' . $x . '&amp;PageName=' . $varPageName . '&amp;PageId=' . $varPageID . '"><b>&nbsp;&nbsp;' . $x . '&nbsp;&nbsp;</b></a></span';

					} else {

						$page_list .= '<span><a href="' . $PHP_SELF . $varQryStr . '&amp;page=' . $x . '"><b>&nbsp;&nbsp;' . $x . '&nbsp;&nbsp;</b></a></span>';

					}

				}

			}

		}

		$varPageList2 = '' . $page_list . '';

		$page_list = "";

		if (($this->page + 1) <= $this->num_pages) {

			if ($varPageName != '' && $varPageID != '') {

				$page_list .= '<span><a href="' . $PHP_SELF . $varQryStr . '&amp;page=' . ($this->page + 1) . '&amp;PageName=' . $varPageName . '&amp;PageId=' . $varPageID . '" class="next" >Next<span>&nbsp;&#187;</span></a></span>';

			} else {

				$page_list .= '<span><a href="' . $PHP_SELF . $varQryStr . '&amp;page=' . ($this->page + 1) . '" class="next">Next<span>&nbsp;&#187;</span></a></span>';

			}

		}

		$varPageList3 = '' . $page_list . '';

		$varPageListing = $varPageList1 . $varPageList2 . $varPageList3;

		$page_list .= "";

		echo $varPageListing;

	}

	function getPaginationString($page = 1, $totalitems, $limit, $adjacents, $targetpage, $pagestring) {
		//defaults
		if (!$adjacents)
			$adjacents = 1;
		if (!$limit)
			$limit = 15;
		if (!$page)
			$page = 1;
		if (!$targetpage)
			$targetpage = "/";

		//other vars
		$prev = $page -1; //previous page is page - 1
		$next = $page +1; //next page is page + 1
		$lastpage = ceil($totalitems / $limit); //lastpage is = total items / items per page, rounded up.
		$lpm1 = $lastpage -1; //last page minus 1

		/* 
			Now we apply our rules and draw the pagination object. 
			We're actually saving the code to a variable in case we want to draw it more than once.
		*/
		$pagination = "";
		if ($lastpage > 1) {
			$pagination .= "<div class=\"pagination\"";
			if ($margin || $padding) {
				$pagination .= " style=\"";
				if ($margin)
					$pagination .= "margin: $margin;";
				if ($padding)
					$pagination .= "padding: $padding;";
				$pagination .= "\"";
			}
			$pagination .= ">";

			//previous button
			if ($page > 1)
				$pagination .= "<a href=\"$targetpage$pagestring$prev\">« prev</a>";
			else
				$pagination .= "<span class=\"disabled\">« prev</span>";

			//pages	
			if ($lastpage < 7 + ($adjacents * 2)) //not enough pages to bother breaking it up
				{
				for ($counter = 1; $counter <= $lastpage; $counter++) {
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>";
				}
			}
			elseif ($lastpage >= 7 + ($adjacents * 2)) //enough pages to hide some
			{
				//close to beginning; only hide later pages
				if ($page < 1 + ($adjacents * 3)) {
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
						if ($counter == $page)
							$pagination .= "<span class=\"current\">$counter</span>";
						else
							$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>";
					}
					$pagination .= "<span class=\"elipses\">...</span>";
					$pagination .= "<a href=\"" . $targetpage . $pagestring . $lpm1 . "\">$lpm1</a>";
					$pagination .= "<a href=\"" . $targetpage . $pagestring . $lastpage . "\">$lastpage</a>";
				}
				//in middle; hide some front and some back
				elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
					$pagination .= "<a href=\"" . $targetpage . $pagestring . "1\">1</a>";
					$pagination .= "<a href=\"" . $targetpage . $pagestring . "2\">2</a>";
					$pagination .= "<span class=\"elipses\">...</span>";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
						if ($counter == $page)
							$pagination .= "<span class=\"current\">$counter</span>";
						else
							$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>";
					}
					$pagination .= "...";
					$pagination .= "<a href=\"" . $targetpage . $pagestring . $lpm1 . "\">$lpm1</a>";
					$pagination .= "<a href=\"" . $targetpage . $pagestring . $lastpage . "\">$lastpage</a>";
				}
				//close to end; only hide early pages
				else {
					$pagination .= "<a href=\"" . $targetpage . $pagestring . "1\">1</a>";
					$pagination .= "<a href=\"" . $targetpage . $pagestring . "2\">2</a>";
					$pagination .= "<span class=\"elipses\">...</span>";
					for ($counter = $lastpage - (1 + ($adjacents * 3)); $counter <= $lastpage; $counter++) {
						if ($counter == $page)
							$pagination .= "<span class=\"current\">$counter</span>";
						else
							$pagination .= "<a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a>";
					}
				}
			}

			//next button
			if ($page < $counter -1)
				$pagination .= "<a href=\"" . $targetpage . $pagestring . $next . "\">next »</a>";
			else
				$pagination .= "<span class=\"disabled\">next »</span>";
			$pagination .= "</div>\n";
		}
		//echo $pagination;
		return $pagination;

	}

}
?>