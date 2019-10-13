<?php

 ?>
<div class="container-fluid spf-wrapper">	
	
	<?php if ( $_GET['cat']): ?>
		<?php foreach ( $this->spf_have_topics( $_GET['cat'] ) as $topic ): ?>
			<div class="col-xs-12 spf-post">
				<div class="col-xs-12 col-sm-9 col-md-9" role="article-presentation">
					<?php echo $topic['author']; ?>
					<?php echo $topic['title']; ?>
				</div>
			</div>
		<?php endforeach; ?>
	<?php elseif($_GET['topic']): ?>		
		<?php foreach ( $this->spf_show_topic( $_GET['topic'] ) as $post ): ?>
			<div class="col-xs-12 spf-post">
				<div class="col-xs-12 col-sm-9 col-md-9" role="article-presentation">
					
					<?php echo $post['post_content']; ?>
					<?php echo $post['username']; ?>
					<?php echo $post['posted_at']; ?>
				</div>
			</div>
		<?php endforeach; ?>
	<?php else: ?>		

				<?php foreach ( $this->spf_have_categories() as $category ): ?>
					<div class="col-xs-12 spf-cat">
					<div class="col-xs-12 ">
						<div class="col-xs-12" role="article-presentation">
							
							<a href="?cat=<?php echo $category['id']; ?>">
								<?php echo $category['name']; ?>
							</a>
						</div>
						<div class="col-xs-12" role="article-presentation">
							
							<a href=""><?php echo $category['description']; ?></a>
						</div>
					</div>
					<hr>
					</div>
				<?php endforeach; ?>
			
		
	<?php endif; ?>
	
</div>

<?php ?>


