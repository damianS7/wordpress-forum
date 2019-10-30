<?php include_once('userbar.php'); ?>
<?php include_once('breadcrumb.php'); ?>
<?php if (is_array($data['forums'])): ?>
	<div class="card text-white bg-primary mb-3">
		<div class="card-header">Forums</div>
		<?php foreach ($data['forums'] as $forum): // Listado de categorias?>
			<div class="card-body">
				<h4 class="card-title">
					<a href="<?php echo get_permalink() . "topics/". $forum['id']; ?>" class="card-link">
						<?php echo $forum['name']; ?>
					</a>
				</h4>
				<p class="card-text"><?php echo $forum['description']; ?></p>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

