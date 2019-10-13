<div class="card text-white bg-primary mb-3">
	<div class="card-header">Categories</div>
	<?php foreach ( $this->spf_have_categories() as $category ): // Listado de categorias ?>
		<div class="card-body">
			<h4 class="card-title">
				<a href="?cat=<?php echo $category['id']; ?>">
					<?php echo $category['name']; ?>
				</a>
			</h4>
			<p class="card-text"><?php echo $category['description']; ?></p>
		</div>
		<?php endforeach; ?>
	</div>
</div>