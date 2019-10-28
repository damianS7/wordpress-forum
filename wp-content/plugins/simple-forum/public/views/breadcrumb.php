<ol class="breadcrumb">
	<?php if (strpos(get_permalink(), 'spf-show-topics') !== false): ?>
        <li class="breadcrumb-item"><a href="<?php echo home_url() . '/spf-show-forums'; ?>">SPF Forums</a></li>
		<li class="breadcrumb-item"><?php echo $data['forum']->name; ?></li>
    <?php elseif (strpos(get_permalink(), 'spf-show-posts') !== false): ?>
        <li class="breadcrumb-item"><a href="<?php echo home_url() . '/spf-show-forums'; ?>">SPF Forums</a></li>
		<li class="breadcrumb-item"><a href="<?php echo home_url() . '/spf-show-topics/' . $data['topic']->cat_id; ?>"><?php echo $data['topic']->subforum; ?></a></li>
        <li class="breadcrumb-item"><?php echo substr($data['topic']->title, 0, 5); ?></li>
	<?php elseif (strpos(get_permalink(), 'spf-show-forums') !== false): ?>
        <li class="breadcrumb-item">SPF Forums</li>
	<?php endif; ?>
</ol>
