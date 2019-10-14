<pre>
<?php
$page = get_query_var('page');
echo $page;

$url = home_url();
echo $url;
?>
</pre>
<ol class="breadcrumb">
  <li class="breadcrumb-item"><a href="<?php echo $this->get_current_url(); ?>">Home</a></li>
	<?php if( !empty( get_query_var('spf_topic') ) ): ?>
		<li class="breadcrumb-item"><a href="?spf-cat=<?php echo get_query_var('spf_cat'); ?>">Category ...</a></li>
		<li class="breadcrumb-item active">Topic X</li>
	<?php elseif( !empty (get_query_var('spf_cat') ) ): ?>
		<li class="breadcrumb-item active">Category X</li>
	<?php endif; ?>
</ol>
<div class="card text-white bg-primary mb-3">
	<div class="card-header">Forums</div>
	<?php foreach ( $this->spf_get_forums() as $forum ): // Listado de categorias ?>
		<div class="card-body">
			<h4 class="card-title">
				<a href="<?php echo home_url() . "/spf-topics/". $forum['id']; ?>" class="card-link">
					<?php echo $forum['name']; ?>
				</a>
			</h4>
			<p class="card-text"><?php echo $forum['description']; ?></p>
		</div>
	<?php endforeach; ?>
</div>

