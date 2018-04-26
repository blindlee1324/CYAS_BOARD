<?php
	// page validation
	if(empty($_GET['page'])) {
		$_GET['page'] = 1;
	}
	
	// search_type validation
	if(empty($_GET['search_type']) || !($_GET['search_type'] == 'title' || $_GET['search_type'] =='content' || $_GET['search_type'] == 'writer') ) {
		$_GET['search_type'] = null;
	}
	
	// keyword validation
	if(empty($_GET['keyword'])) {
		$_GET['keyword'] = null;
	} else {
		$_GET['keyword'] = preg_replace("/[\r\n\s\t\'\;\"\=\-\-\#\/*]+/","", $_GET['keyword']);
		if(preg_match('/(union|select|from|where)/i', $_GET['keyword'])) {
			$_GET['keyword'] = null;
		}
	}
	
	$paginator = new \App\Paginator($_GET['search_type'], $_GET['keyword']);
?>
<div class="row">
		<?php
			$paginator->dataRender(intval($_GET['page']));
		?>
</div>

<div class="row">
	<a href="/write.php"class="btn btn-primary pull-right">WRITE</a>
</div>
<nav aria-label="page navigation">
	<div class="text-center">
		<?php
			$paginator->navRender(intval($_GET['page']),$_GET['search_type'],$_GET['keyword']);
		?>
	</div>
</nav>
<div class="row">
<div class="text-center">
	<form class="form-inline mr-auto" method="GET" action="/index.php">
		<div class="form-group">
			<select class="form-control" id="search_type" name="search_type">
			  <option value="title">TITLE</option>
			  <option value="content">CONTENT</option>
			  <option value="writer">WRITER</option>
			</select>
		  </div>
		<input name="keyword" class="form-control mr-sm-2" type="text" placeholder="검색어 입력" aria-label="Search" id="keyword">
		<button type="submit" class="btn btn-success" onclick>Search</button>
	</form>
	</div>
</div> 
</div>
