<?php
if ( !empty( $_POST ) && get_query_var('spf_submit') !== NULL ) {
	$this->spf_create_topic(
		get_query_var('spf_topics_cat_id'), 
		get_query_var('spf_topics_user_id'), 
		get_query_var('spf_topics_topic_title'),
		get_query_var('spf_topics_post_content')
	);
}

if(get_query_var('page') == 0) {
	set_query_var('page', 1);
}

?>
<div class="card text-white bg-primary mb-3">
	<div class="card-header">CATEGORY X</div>
	<?php foreach ( $this->spf_get_topics( get_query_var('page') ) as $topic ): // Listado de categorias ?>
		<div class="card-body">
			<h4 class="card-title">
				<a href="<?php echo home_url() . "/spf-posts/". $topic['id']; ?>">
					<?php echo $topic['author']; ?>
				</a>
			</h4>
			<p class="card-text"><?php echo $topic['title']; ?></p>
		</div>
	<?php endforeach; ?>
</div>
<?php // if user is logged ?>
<form method="POST" action="">
  <fieldset>
  	<div class="form-group row">
      <div class="col-sm-12">
        <input type="text" class="form-control-plaintext" name="spf_topics_topic_title" value="Title">
      </div>
    </div>
    <div class="form-group">
      <label for="exampleTextarea">Write for your topic ...</label>
      <textarea class="form-control" name="spf_post_content" rows="3"></textarea>
    </div>
    <button type="submit" name="spf_submit" class="btn btn-block btn-primary">NEW TOPIC</button>
  </fieldset>
  <input type="hidden" name="spf_topics_cat_id" value="<?php echo get_query_var('page'); ?>">
  <input type="hidden" name="spf_topics_user_id" value="1">
</form>
