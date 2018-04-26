<?php

namespace App;

class Paginator {
	private $limit = 1; // posts per a page.
	private $pageRange = 10; // pages on one scene;
	private $totalPages; // total number of pages.
	private $totalPosts; // number of posts.
	
	/*
		@param int $total // ex) 'select count(*) from posts';
	*/
	public function __construct($totalPosts) {
		$this->totalPosts = $totalPosts;
		
		$this->totalPages = floor($this->totalPosts / $this->limit);	
		
		if($this->totalPosts % $this->limit) {
			$this->totalPages++;
		}
		
	}
	
	/*
		@param int $currentPage // ex) $_GET['page']
	*/
	public function render($currentPage = '1', $list_class = 'pagination pagination-sm justify-content-center') {
		if($currentPage > $this->totalPages || $currentPage < 1 || !is_int($currentPage)) {
			$currentPage = 1;
		}
		$startPage = floor(($currentPage - 1) / $this->pageRange) * $this->pageRange + 1;
		$endPage = $startPage + $this->pageRange - 1;
		
		if($endPage > $this->totalPages) {
			$endPage = $this->totalPages;
		}
		
		// html rendering
		$html       = '<ul class="' . $list_class . '">';
		
		
		// step 10 pages next (10 is default. $pageRange)
		if($currentPage > 1) {
			$previous = $currentPage-$this->pageRange;
			if($previous < 1) {
				$previous = 1;
			}
			$html       .= '<li><a href="?page='.($previous).'">&laquo;</a></li>';
		}else {
			$html		.= '<li class="disabled"><span>&laquo;</span></li>';
		}
		
		// back to page 1
		if($startPage > 1) {
			$html       .= '<li><a href="?page=1">1</a></li>';
			$html       .= '<li class="page-item disabled"><span>&hellip;</span></li>';
		}
		
		// page buttons
		for($i = $startPage; $i <= $endPage; $i++) {
			$class = ($currentPage == $i) ? ' class="active"' : "";
			$html       .= '<li'.$class.'><a href="?page='.($i).'">'.$i.'</a></li>';
		}
		
		// jump to end page
		if($endPage < $this->totalPages) {
			$html       .= '<li class="page-item disabled"><span>&hellip;</span></li>';
			$html       .= '<li><a href="?page='.$this->totalPages.'">'.$this->totalPages.'</a></li>';
		}
		
		// back 10 pages
		if($currentPage < $this->totalPages) {
			$next = $currentPage+$this->pageRange;
			if($next > $this->totalPages) {
				$next = $this->totalPages;
			}
			$html       .= '<li><a href="?page='.($next).'">&raquo;</a></li>';
		} else {
			$html       .= '<li class="disabled"><span>&raquo;</span></li>';
		}
		
		
		return print_r($html);
	}
	
	
}