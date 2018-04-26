<?php
	$paginator = new App\Paginator(intval(App\Post::countAll()));
?>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col" style="width: 5%">#</th>
      <th scope="col" style="width: 55%">TITLE</th>
      <th scope="col" style="width: 20%">WRITER</th>
      <th scope="col" style="width: 15%">DATE</th>
	  <th scope="col" style="width: 5%">HIT</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Example1</td>
      <td>Otto(@mdo)</td>
      <td>18-04-25 14:22</td>
	  <td>3</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton(@fat)</td>
      <td>18-04-25 14:36</td>
	  <td>2</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird(@twitter)</td>
      <td>18-04-25 14:52</td>
	  <td>7</td>
    </tr>
  </tbody>
</table>
<div class="row">
	<a href="/write.php"class="btn btn-primary pull-right">WRITE</a>
</div>
<nav aria-label="page navigation">
	<div class="text-center">
<?php
	if(empty($_GET['page'])) {
		$_GET['page'] = 1;
	}
	$paginator->render(intval($_GET['page']));
?>
	</div>
</nav>