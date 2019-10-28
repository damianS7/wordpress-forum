<?php include_once('userbar.php'); ?>
<?php include_once('breadcrumb.php'); ?>
<?php if (is_array($data['topics'])): ?>
	<ul class="list-group">
		<?php foreach ($data['topics'] as $topic) : // Listado de categorias
            ?>
			<li class="list-group-item d-flex justify-content-between align-items-center">
				<a href="<?php echo home_url() . "/spf-show-post/" . $topic['id']; ?>">
					<?php echo $topic['title']; ?>
				</a>
				<span class="badge badge-primary"><?php echo $topic['subforum']; ?></span>
				<span class="badge badge-primary"><?php echo $topic['author']; ?></span>
				<span class="badge badge-primary "><?php echo $topic['created_at']; ?></span>
				<span class="badge badge-primary badge-pill"><?php echo $topic['total_posts']; ?></span>
			</li>
		<?php endforeach; ?>
	</ul>
<div class="btn-group" role="group" aria-label="Basic example">
<form action="">
  <button type="button" class="btn btn-secondary">First page</button>
  <button type="button" class="btn btn-secondary">Previous</button>
  <button type="button" class="btn btn-secondary">Next</button>
  <button type="submit" class="btn btn-secondary" name="last">Last page</button>
</form>
</div>
<?php endif; ?>
<hr />
<?php if (SimpleForumAuth::is_auth()): ?>
	<form method="POST" action="">
		<fieldset>
			<div class="form-group row">
				<div class="col-sm-12">
					<input type="text" class="form-control-plaintext" name="topic_title" placeholder="Title">
				</div>
			</div>
			<div class="form-group">
				<label for="exampleTextarea">Write for your topic ...</label>
				<textarea class="form-control" name="post_content" rows="3"></textarea>
			</div>
			<button type="submit" name="submit" class="btn btn-block btn-primary">NEW TOPIC</button>
		</fieldset>
		<input type="hidden" name="forum_id" value="<?php echo $data['forum']->id; ?>">
	</form>
<?php else: ?>
Please create an account to start a topic
<?php endif; ?>
<?php if (!empty($data['error_message'])): ?>
<div class="alert alert-danger">
  <?php echo $data['error_message']; ?>
</div>
<?php endif; ?>
<?php if (!empty($data['success_message'])): ?>
<div class="alert alert-success">
  <?php echo $data['success_message']; ?>
</div>
<?php endif; ?>
