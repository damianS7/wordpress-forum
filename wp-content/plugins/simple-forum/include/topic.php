<div class="card text-white bg-primary mb-3">
	<div class="card-header">CATEGORY X</div>
	<?php foreach ( $this->spf_show_topic( $this->get_query_var('topic') ) as $post ): // Listado de categorias ?>
		<div class="card-body">
			<h4 class="card-title">
				<?php echo $post['posted_at']; ?>
				<?php echo $post['username']; ?>
			</h4>
			<p class="card-text"><?php echo $post['post_content']; ?></p>
		</div>
	<?php endforeach; ?>
</div>
</div>

