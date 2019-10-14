<?php
if ( !empty( $_POST ) && get_query_var('spf_submit') !== NULL ) {
	
	$this->spf_create_post(
		get_query_var('spf_posts_topic_id'), 
		get_query_var('spf_posts_user_id'), 
		get_query_var('spf_posts_content')
	);
}

if(get_query_var('page') == 0) {
	set_query_var('page', 1);
}
?>
<div class="card text-white bg-primary mb-3">
	<div class="card-header">CATEGORY X</div>
	<?php foreach ( $this->spf_get_topic( get_query_var('page') ) as $post ): // Listado de categorias ?>
		<div class="card-body">
			<h4 class="card-title">
				<?php echo $post['posted_at']; ?>
				<?php echo $post['username']; ?>
			</h4>
			<p class="card-text"><?php echo $post['post_content']; ?></p>
		</div>
	<?php endforeach; ?>
</div>
<?php // if user is logged ?>
<form method="POST" action="">
  <fieldset>
    <div class="form-group">
      <label for="exampleTextarea">Say something in this post ...</label>
      <textarea class="form-control" name="spf_posts_content" rows="3"></textarea>
    </div>
    <button type="submit" name="spf_submit" class="btn btn-block btn-primary">NEW POST</button>
  </fieldset>
  <input type="hidden" name="spf_posts_user_id" value="1">
  <input type="hidden" name="spf_posts_topic_id" value="<?php echo get_query_var('page'); ?>">
</form>

