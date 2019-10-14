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
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo $this->get_current_url(); ?>">Home</a></li>
	<?php if( !empty( get_query_var('spf_topic') ) ): ?>
		<li class="breadcrumb-item"><a href="?spf-cat=<?php echo get_query_var('spf_cat'); ?>">Category ...</a></li>
		<li class="breadcrumb-item active">Topic X</li>
	<?php elseif( !empty (get_query_var('spf_cat') ) ): ?>
		<li class="breadcrumb-item active">Category X</li>
	<?php endif; ?>
</ol>

<ul class="list-group">
	<?php foreach ( $this->spf_get_topics( get_query_var('page') ) as $topic ): // Listado de categorias ?>
		<li class="list-group-item d-flex justify-content-between align-items-center">
			<a href="<?php echo home_url() . "/spf-posts/". $topic['id']; ?>">
				<?php echo $topic['title']; ?>
			</a>
			<span class="badge badge-primary"><?php echo $topic['subforum']; ?></span>
			<span class="badge badge-primary"><?php echo $topic['author']; ?></span>
			<span class="badge badge-primary "><?php echo $topic['created_at']; ?></span>
			<span class="badge badge-primary badge-pill"><?php echo $topic['total_posts']; ?></span>	
		</li>		
	<?php endforeach; ?>
</ul>
<hr/>
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
