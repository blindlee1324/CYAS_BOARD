<form method="POST" action="/app/Controller/posts.create.php">
  <div class="form-group">
	<label for="title">TITLE</label>
	<input type="text" class="form-control" name="title" id="title" placeholder="제목을 입력하세요" maxlength="128">
  </div>
  <div class="container">
	<p class="text-danger"><?php if(isset($_SESSION['t_valid'])) print_r($_SESSION['t_valid']); ?></p>
  </div>
  <!-- ckeditor here -->
  <script src="/resources/ckeditor/ckeditor.js"/></script>
  <div class="form-group">
	<label for="content">CONTENT</label>
	<textarea name="content" class="form-control" id="content" rows="10" required minlength="10"><?php if(isset($_SESSION['content'])) print_r($_SESSION['content']) ?></textarea>
	<script>
		CKEDITOR.replace('content');
	</script>
  </div>
  <!-- ckeditor here -->
  <div class="container">
	<p class="text-danger"><?php if(isset($_SESSION['c_valid'])) print_r($_SESSION['c_valid']); ?></p>
  </div>
  <div class="col-auto">
	<input class="btn btn-primary pull-right" type="submit" value="Submit">
  </div>
</form>

<?php
	if(isset($_SESSION['t_valid'])) unset($_SESSION['t_valid']);
	if(isset($_SESSION['c_valid'])) unset($_SESSION['c_valid']);
	if(isset($_SESSION['content'])) unset($_SESSION['content']);
?>