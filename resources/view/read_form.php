<?php
	// $_GET['no'] Validation
	if(empty($_GET['no'])) {
		header('Location: /');
	} else {
		$temp = preg_replace("/[^0-9]/","", $_GET['no']);
		
		if($temp != $_GET['no']) {
			header('Location: /');
		} else {
			$post = \App\Post::read($_GET['no']);
			
			if(empty($post)) {
				header('Location: /');
			} else {
				\App\Post::hit($_GET['no']);
			}
		}
	}
?>
 <div class="row">
        <!-- Post Content Column -->
        <div class="col-lg-8">

          <!-- Title -->
          <h1 class="mt-4">[<?php print_r($post['id']); ?>] <?php print_r($post['title']); ?></h1>

          <!-- Author -->
          <p class="lead">
            by
            <?php print_r($post['user_name'].'(@'.$post['user_screen_id'].')'); ?>
          </p>

          <hr>

          <!-- Date/Time -->
          <p>HIT: <?php print_r($post['hit']+1); ?> DATETIME: <?php print_r($post['created']); ?></p>

          <hr>

          <!-- Post Content -->
		  <?php print_r($post['content']); ?>
		  
		  <hr>
		  
		  <a onclick="history.go(-1);" class="btn btn-primary">BACK</a>
		  <?php if(isset($_SESSION['id']) && $_SESSION['id'] == $post['user_id']) { ?>
			<a href="/app/Controller/delete.php?no=<?php $post['id'] ?>" class="btn btn-danger pull-right">DELETE</a>
			<a href="/update.php?no=<?php $post['id'] ?>" class="btn btn-success pull-right">EDIT</a>
		  <?php } ?>
		  
		</div>
</div>
