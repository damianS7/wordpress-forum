<?php 

?>

<div class="container-fluid spf-wrapper">	
	<?php if ( $_GET['cat']): // Muestra los topics de una categoria ?>
		<?php foreach ( $this->spf_have_topics( $this->get_query_var('cat') ) as $topic ): ?>
			<div class="col-xs-12 spf-post">
				<div class="col-xs-12 col-sm-9 col-md-9" role="article-presentation">
					<?php echo $topic['author']; ?>
					<a href="?topic=<?php echo $topic['id']; ?>">
						<?php echo $topic['title']; ?>
					</a>
				</div>
			</div>
		<?php endforeach; ?>
		<?php elseif($_GET['topic']): // Muestras un topic junto con los posts de los usuarios  ?>		
			<?php foreach ( $this->spf_show_topic( $this->get_query_var('topic') ) as $post ): ?>
				<div class="col-xs-12 spf-post">
					<div class="col-xs-12 col-sm-9 col-md-9" role="article-presentation">
						<?php echo $post['post_content']; ?>
						<?php echo $post['username']; ?>
						<?php echo $post['posted_at']; ?>
					</div>
				</div>
			<?php endforeach; ?>
			<?php else: ?>		
				<?php foreach ( $this->spf_have_categories() as $category ): // Listado de categorias ?>
					<div class="col-xs-12 spf-cat">
						<div class="col-xs-12 ">
							<div class="col-xs-12" role="article-presentation">
								<a href="?cat=<?php echo $category['id']; ?>">
									<?php echo $category['name']; ?>
								</a>
							</div>
							<div class="col-xs-12" role="article-presentation">
								<?php echo $category['description']; ?>
							</div>
						</div>
						<hr>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>		
	<?php ?>
</div>


