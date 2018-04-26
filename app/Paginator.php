<?php

namespace App;

class Paginator {
	private $limit = 10; // posts per a page.
	private $pageRange = 10; // pages on one scene;
	private $totalPages; // total number of pages.
	private $totalPosts; // number of posts.
	
	/*
		@param int $total // ex) 'select count(*) from posts';
		@param string $serach_type // 1.all / 2.title / 3.content / 4.writer
		@param string $keyword
	*/
	public function __construct($search_type=null, $keyword=null) {
		$pdo = new Connection();
		if($keyword == null) {
			$sql = 'select count(*) from posts';
		} else {
			switch ($search_type) {
				case "title":
					$sql = "select count(*) from posts WHERE title LIKE '%".$keyword."%'";
					break;
				case "content":
					$sql = "select count(*) from posts WHERE content LIKE '%".$keyword."%'";
					break;
				case "writer":
					$sql = "select count(*) from posts WHERE user_name LIKE '%".$keyword."%'";
			}
		}
		$result = $pdo->query($sql)->fetchColumn();
		
		$this->totalPosts = $result;
		
		$this->totalPages = floor($this->totalPosts / $this->limit);	
		
		if($this->totalPosts % $this->limit) {
			$this->totalPages++;
		}
	}
	
	/*
		@param int $currentPage // ex) $_GET['page']
		@param string list_class // ul class
	*/
	public function navRender($currentPage = '1', $search_type = null, $keyword = null) {
		if($this->totalPosts == 0) {
			return;
		}
		if($currentPage > $this->totalPages || $currentPage < 1 || !is_int($currentPage)) {
			$currentPage = 1;
		}
		$startPage = floor(($currentPage - 1) / $this->pageRange) * $this->pageRange + 1;
		$endPage = $startPage + $this->pageRange - 1;
		
		if($endPage > $this->totalPages) {
			$endPage = $this->totalPages;
		}
		
		// html rendering
		$html       = '<ul class="pagination pagination-sm justify-content-center">';
		
		
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
		if($search_type != null && $keyword != null) {
			for($i = $startPage; $i <= $endPage; $i++) {
				$class = ($currentPage == $i) ? ' class="active"' : "";
				$html       .= '<li'.$class.'><a href="?search_type='.$search_type.'&keyword='.$keyword.'&page='.($i).'">'.$i.'</a></li>';
			}
		} else {
			for($i = $startPage; $i <= $endPage; $i++) {
				$class = ($currentPage == $i) ? ' class="active"' : "";
				$html       .= '<li'.$class.'><a href="?page='.($i).'">'.$i.'</a></li>';
			}
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
	
	public function dataRender($currentPage = '1', $search_type=null, $keyword=null) {
		if($this->totalPosts == 0) {
			return print_r("<h1 class='cover-heading'>검색결과가 없습니다.</h1>");
		}
		$pdo = new Connection();
		if($keyword == null) {
			$sql = 'select id, title, user_name, user_screen_id, user_image, created, hit from posts order by created desc LIMIT '.($currentPage-1)*$this->limit.', '.$this->limit;
		} else {
			switch ($search_type) {
				case "title":
					$sql = "select id, title, user_name, user_screen_id, user_image, created, hit from posts where title like '%".$keyword."%' order by created desc LIMIT ".($currentPage-1)*$this->limit.", ".$this->limit;
					break;
				case "content":
					$sql = "select id, title, user_name, user_screen_id, user_image, created, hit from posts where content like '%".$keyword."%' order by created desc LIMIT ".($currentPage-1)*$this->limit.", ".$this->limit;
					break;
				case "writer":
					$sql = "select id, title, user_name, user_screen_id, user_image, created, hit from posts where writer like '%".$keyword."%' order by created desc LIMIT ".($currentPage-1)*$this->limit.", ".$this->limit;
			}
		}
		$result = $pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
		
		$html = '<table class="table table-striped">
					  <thead>
						<tr>
						  <th scope="col" style="width: 5%">#</th>
						  <th scope="col" style="width: 55%">TITLE</th>
						  <th scope="col" style="width: 20%">WRITER</th>
						  <th scope="col" style="width: 15%">DATE</th>
						  <th scope="col" style="width: 5%">HIT</th>
						</tr>
					  </thead>
					  <tbody>';
		if($search_type != null && $keyword != null) {
			foreach($result as $post) {
				$html .= '<tr>';
				$html .= '<th scope="row">'.$post['id'].'</th>';
				$html .= '<td>'. $post['title'] .'</td>';
				$html .= '<td><img src='.$post['user_image'].' height=25 width=25>'. $post['user_name'] .'(@'.$post['user_screen_id'].')</td>';
				$html .= '<td>'. $post['created'] .'</td>';
				$html .= '<td>'. $post['hit'] .'</td>';
			}
		} else {
			foreach($result as $post) {
				$html .= '<tr>';
				$html .= '<th scope="row">'.$post['id'].'</th>';
				$html .= '<td>'. $post['title'] .'</td>';
				$html .= '<td><img src='.$post['user_image'].' height=25 width=25>'. $post['user_name'] .'(@'.$post['user_screen_id'].')</td>';
				$html .= '<td>'. $post['created'] .'</td>';
				$html .= '<td>'. $post['hit'] .'</td>';
			}
		}
		$html .= '</tbody>
			</table>'; 
		
		return print_r($html);
	} 
}