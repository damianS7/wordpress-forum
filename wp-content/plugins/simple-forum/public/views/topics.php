
<?php if (is_array($data['topics'])): ?>
<div id="pagination-top" class="row">
	<?php include('pagination.php'); ?>
</div>
<div class="row">
	<div class="col-sm-12">
	<ul class="list-group">
	<?php foreach ($data['topics'] as $topic) : // Listado de categorias?>
		<li class="list-group-item align-items-center">
			<div class="row">
				<div class="col-sm-7">			
					<a href="<?php echo SimpleForum::pagination_url('posts', $topic['id'], 1); ?>">
						<?php echo $topic['title']; ?>
					</a>
				</div>
				<div class="col-sm-5 text-right">
					<span class="badge badge-primary"><?php echo $topic['subforum']; ?></span>
					<span class="badge badge-primary"><?php echo $topic['author']; ?></span>
					<span class="badge badge-primary"><?php echo $topic['created_at']; ?></span>
					<span class="badge badge-primary badge-pill"><?php echo $topic['total_posts']; ?></span>
				</div>
			</div>
		</li>
	<?php endforeach; ?>
</ul>
</div>
</div>
<div id="pagination-bottom" class="row">
	<?php include('pagination.php'); ?>
</div>
<?php endif; ?>
<div class="row">
	<div class="col-sm-12">
		<?php if (SPF_AccountController::is_auth()): ?>
			<form method="POST">
				<fieldset>
					<div class="form-group row">
						<div class="col-sm-12">
							<input type="text" class="form-control-plaintext" name="topic_title" placeholder="Title">
						</div>
					</div>
					<div class="form-group">
						<textarea class="form-control" name="post_content" rows="4" placeholder="Say something..."></textarea>
					</div>
					<button type="submit" name="submit" class="btn btn-block btn-primary">NEW TOPIC</button>
				</fieldset>
			</form>
		<?php else: ?>
			<strong>
				Please create an account to start a topic
			</strong>
		<?php endif; ?>
	</div>
</div>
