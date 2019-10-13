<div class="card text-white bg-primary mb-3">
	<div class="card-header">CATEGORY X</div>
	<?php foreach ( $this->spf_have_topics( $this->get_query_var('cat') ) as $topic ): // Listado de categorias ?>
		<div class="card-body">
			<h4 class="card-title">
				<a href="?topic=<?php echo $topic['id']; ?>">
					<?php echo $topic['author']; ?>
				</a>
			</h4>
			<p class="card-text"><?php echo $topic['title']; ?></p>
		</div>
		<?php endforeach; ?>
	</div>
</div>